<?php

use yii\helpers\Url;

/* @var $this yii\web\View */
?>
<script>

    var ns = ns || {
        _queueProduct: [],
        masters: {},
        ensureProduct: function () {
            if (ns.masters._loaded) {
                angular.forEach(ns._queueProduct, function (details, key) {
                    if (details != undefined) {
                        angular.forEach(details, function (detail) {
                            if (!detail.product) {
                                detail.product = ns.masters.products[detail.product_id];
                            }
                        });
                        ns._queueProduct[key] = undefined;
                    }
                });
            }
        },
        getMaster: function (Resource) {
            if (!ns.masters._loaded) {
                ns.masters = Resource.master({}, function (result) {
                    // products
                    ns.masters._products = Object.keys(result.products).map(function (key) {
                        return result.products[key];
                    });
                    ns.masters._loaded = true;
                    ns.ensureProduct();
                });
            }
            return {
                products: ns.masters._products,
                suppliers: ns.masters.suppliers,
            }
        },
        getModel: function (Resource, id) {
            return Resource.get({
                id: id,
            }, function (data) {
                data.details = data.details || [];
                ns._queueProduct.push(data.details);
                ns.ensureProduct();
            });
        },
    };

    angular.module('dApp', [
        'ngRoute',
        'ui.bootstrap',
        'mdm.angular',
        'ngResource',
    ])
        .factory('Resource', ['$resource',
            function ($resource) {
                return $resource('<?= Url::to(['resource']) ?>', {id:'@id'}, {
                    query: {
                        params: {'per-page': 10, expand: 'supplier,branch', },
                        isArray:true,
                    },
                    get: {
                        params: {expand: 'supplier,branch,details', },
                    },
                    save: {
                        headers: {'X-CSRF-Token': yii.getCsrfToken()},
                    },
                    update: {
                        method: 'PUT',
                        headers: {'X-CSRF-Token': yii.getCsrfToken()},
                    },
                    master: {
                        method: 'GET',
                        url: '<?= Url::to(['/masters', 'masters' => 'products,suppliers,barcodes']); ?>'
                    },
                });
            }])
        .config(['$routeProvider',
            function ($routeProvider) {
                $routeProvider.
                    when('/view/:id', {
                        templateUrl: '<?= Url::to(['template', 'view' => 'view']) ?>',
                        controller: 'ViewCtrl',
                        name: 'view',
                    }).
                    when('/edit/:id', {
                        templateUrl: '<?= Url::to(['template', 'view' => 'edit']) ?>',
                        controller: 'CreateEditCtrl',
                        name: 'edit',
                    }).
                    when('/create', {
                        templateUrl: '<?= Url::to(['template', 'view' => 'create']) ?>',
                        controller: 'CreateEditCtrl',
                        name: 'create',
                    }).
                    when('/list', {
                        templateUrl: '<?= Url::to(['template', 'view' => 'list']) ?>',
                        controller: 'ListCtrl',
                        name: 'list',
                    }).
                    otherwise({
                        redirectTo: '/list',
                    });
            }])
        .controller('ListCtrl', ['$scope', 'Resource',
            function ($scope, Resource) {
                var headerPageMap = {
                    totalItems: 'X-Pagination-Total-Count',
                    pageCount: 'X-Pagination-Page-Count',
                    currentPage: 'X-Pagination-Current-Page',
                    itemPerPage: 'X-Pagination-Per-Page',
                };
                
                $scope.pager = {maxSize: 5};

                var gotoPage = function (page) {
                    $scope.rows = Resource.query({
                        page: page,
                    }, function (r, headers) {
                        angular.forEach(headerPageMap, function (val, key) {
                            $scope.pager[key] = headers(val);
                        });
                    });
                }

                $scope.pageChange = function () {
                    gotoPage($scope.pager.currentPage);
                }

                gotoPage();
            }])
        .controller('ViewCtrl', ['$scope', '$routeParams', 'Resource',
            function ($scope, $routeParams, Resource) {
                $scope.masters = ns.getMaster(Resource);
                $scope.model = ns.getModel(Resource, $routeParams.id);
            }])
        .controller('CreateEditCtrl', ['$scope', '$routeParams', '$route', 'Resource',
            function ($scope, $routeParams, $route, Resource) {
                $scope.masters = ns.getMaster(Resource);
                var _isCreate = $route.current.name == 'create',
                    _action, _id;

                if (_isCreate) {
                    $scope.model = new Resource({details: []});
                    _id = undefined;
                    _action = '$save';
                } else {
                    $scope.model = ns.getModel(Resource, $routeParams.id);
                    _id = $routeParams.id;
                    _action = '$update';
                }

                $scope.save = function () {
                    if ($scope.model.supplier) {
                        $scope.model.supplier_id = $scope.model.supplier.id;
                    }
                    $scope.model[_action]({id: _id}, function (model) {
                        window.location.hash = '#/view/' + model.id;
                    }, function (error) {

                    });
                }

                $scope.dt = {
                    opened: false,
                    dateOptions: {},
                    format: 'dd-MM-yyyy',
                    open: function ($event) {
                        $event.preventDefault();
                        $event.stopPropagation();
                        $scope.dt.opened = true;
                    }
                }

                var _fokusKey = -1;
                $scope.setFokusQty = function () {
                    if (_fokusKey >= 0) {
                        jQuery('tr[data-key="' + _fokusKey + '"] input[data-field="qty"]').focus().select();
                        _fokusKey = -1;
                    }
                };

                var addItem = function (item) {
                    var has = false;
                    var key = 0;
                    for (key in $scope.model.details) {
                        var detail = $scope.model.details[key];
                        if (detail.product_id == item.id) {
                            has = true;
                            detail.qty++;
                            _fokusKey = key;
                            break;
                        }
                    }
                    if (!has) {
                        key = $scope.model.details.length;
                        var uom_id;
                        if (item.uoms[0]) {
                            uom_id = item.uoms[0].id;
                        }
                        $scope.model.details.push({
                            product_id: item.id,
                            product: item,
                            uom_id: uom_id,
                            qty: 1, price: 0
                        });
                        _fokusKey = key;
                    }
                }

                $scope.changeProduct = function (event) {
                    if (event.keyCode == 13 && angular.isString($scope.selectedProduct)) {
                        var code = $scope.selectedProduct;
                        if (ns.masters.barcodes[code]) {
                            var id = ns.masters.barcodes[code];
                            addItem(ns.masters.products[id]);
                            $scope.selectedProduct = '';
                        }
                    }
                }

                $scope.selectProduct = function (item) {
                    addItem(item);
                    $scope.selectedProduct = '';
                }

                $scope.deleteRow = function (idx) {
                    var temp = [];
                    for (var key in $scope.model.details) {
                        if (key != idx) {
                            temp.push($scope.model.details[key])
                        }
                    }
                    $scope.model.details = temp;
                    jQuery('#product').focus();
                }

                $scope.subTotal = function (detail) {
                    return detail.qty * detail.price;
                }
            }]);
</script>