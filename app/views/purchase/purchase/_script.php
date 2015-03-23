<?php

use yii\helpers\Url;
use app\components\Helper;

/* @var $this yii\web\View */

$masters = [];
foreach (['products', 'suppliers', 'barcodes'] as $name) {
    $method = 'get' . $name;
    $masters[$name] = Helper::$method();
}
$masters['_products'] = array_values($masters['products']);
?>
<script>

    var ns = {
        masters:<?= json_encode($masters) ?>,
        ensureProduct: function (items) {
            angular.forEach(items, function (item) {
                if (!item.product) {
                    item.product = ns.masters.products[item.product_id];
                }
            });
        },
        getMaster: function () {
            return {
                products: ns.masters._products,
                suppliers: ns.masters.suppliers,
            }
        },
        getModel: function (Resource, id) {
            return Resource.get({
                id: id,
            }, function (data) {
                data.items = data.items || [];
                ns.ensureProduct(data.items);
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
                return $resource('<?= Url::to(['resource']) ?>', {}, {
                    query: {
                        params: {'per-page': 10, expand: 'supplier,branch', },
                        isArray: true,
                    },
                    get: {
                        params: {expand: 'supplier,branch,items', },
                    },
                    save: {
                        headers: {'X-CSRF-Token': yii.getCsrfToken()},
                    },
                    update: {
                        method: 'PUT',
                        headers: {'X-CSRF-Token': yii.getCsrfToken()},
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
                    when('/receive/:id', {
                        templateUrl: '<?= Url::to(['template', 'view' => 'receive']) ?>',
                        controller: 'ReceiveCtrl',
                        name: 'receive',
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

                var gotoPage = function () {
                    $scope.rows = Resource.query({
                        page: $scope.pager.currentPage,
                    }, function (r, headers) {
                        angular.forEach(headerPageMap, function (val, key) {
                            $scope.pager[key] = headers(val);
                        });
                    });
                }

                $scope.pageChange = function () {
                    gotoPage();
                }

                gotoPage();
                $scope.doSearch = function (event) {
                    if (event.keyCode == 13) {
                        gotoPage()
                    }
                }
            }])
        .controller('ViewCtrl', ['$scope', '$routeParams', 'Resource',
            function ($scope, $routeParams, Resource) {
                $scope.masters = ns.getMaster(Resource);
                $scope.model = ns.getModel(Resource, $routeParams.id);
            }])
        .controller('CreateEditCtrl', ['$scope', '$routeParams', '$route', 'Resource',
            function ($scope, $routeParams, $route, Resource) {
                $scope.masters = ns.getMaster(Resource);
                var _fields = ['supplier_id', 'date', 'items'];
                var _isCreate = $route.current.name == 'create',
                    _action, _id;

                if (_isCreate) {
                    $scope.model = new Resource({items: []});
                    _id = undefined;
                    _action = 'save';
                } else {
                    $scope.model = ns.getModel(Resource, $routeParams.id);
                    _id = $routeParams.id;
                    _action = 'update';
                }

                $scope.save = function () {
                    if ($scope.model.supplier) {
                        $scope.model.supplier_id = $scope.model.supplier.id;
                    }
                    var data = {};
                    angular.forEach(_fields, function (field) {
                        data[field] = $scope.model[field];
                    });
                    Resource[_action]({id: _id}, data, function (model) {
                        window.location.hash = '#/view/' + model.id;
                    }, function (error) {

                    });
                }
                
                $scope.discard = function (){
                    if(_isCreate){
                        window.location.hash = '#/list';
                    }else{
                        window.location.hash = '#/view/' + _id;
                    }
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

                var addItem = function (product) {
                    var has = false;
                    var key = 0;
                    for (key in $scope.model.items) {
                        var item = $scope.model.items[key];
                        if (item.product_id == product.id) {
                            has = true;
                            item.qty++;
                            _fokusKey = key;
                            break;
                        }
                    }
                    if (!has) {
                        key = $scope.model.items.length;
                        var uom_id;
                        if (product.uoms[0]) {
                            uom_id = product.uoms[0].id;
                        }
                        $scope.model.items.push({
                            product_id: product.id,
                            product: product,
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

                $scope.selectProduct = function (product) {
                    console.log('sss');
                    addItem(product);
                    $scope.selectedProduct = '';
                }

                $scope.deleteRow = function (idx) {
                    var temp = [];
                    for (var key in $scope.model.items) {
                        if (key != idx) {
                            temp.push($scope.model.items[key])
                        }
                    }
                    $scope.model.items = temp;
                    jQuery('#product').focus();
                }

                $scope.subTotal = function (item) {
                    return item.qty * item.price;
                }
            }]);
</script>