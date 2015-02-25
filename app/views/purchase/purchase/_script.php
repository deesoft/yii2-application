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
        initMaster: function ($scope, $http) {
            // products
            $scope.masters = $scope.masters || {};

            if (!ns.masters._loaded) {
                $http.get('<?= Url::to(['/masters', 'masters' => 'products,suppliers,barcodes']) ?>')
                    .success(function (result) {
                        angular.forEach(result, function (data, key) {
                            ns.masters[key] = data;
                        });
                        // products
                        $scope.masters.products = Object.keys(result.products).map(function (key) {
                            return result.products[key];
                        });
                        // supplier
                        $scope.masters.suppliers = result.suppliers;
                        ns.masters._loaded = true;
                        ns.ensureProduct();
                    });
            } else {
                $scope.masters.products = Object.keys(ns.masters.products).map(function (key) {
                            return ns.masters.products[key];
                        });;
                $scope.masters.suppliers = ns.masters.suppliers;
            }

        },
        ctrlFunc: function ($scope, $http, $routeParams) {
            ns.initMaster($scope, $http);

            if ($routeParams === undefined) {
                $scope.model = {
                    details: [],
                }
                $scope.save = function () {
                    $scope.model.supplier_id = $scope.model.supplier.id;
                    $http.post('<?= Url::to(['create']) ?>', $scope.model)
                        .success(function (data, status) {
                            if (status == 200) {
                                window.location.hash = '#/view/' + data.id;
                            }
                        });
                }

            } else {
                $http.get('<?= Url::to(['view']) ?>', {
                    params: {
                        id: $routeParams.id,
                        expand: 'details,supplier,branch'
                    }
                }).success(function (data) {
                    data.details = data.details || [];
                    ns._queueProduct.push(data.details);
                    ns.ensureProduct();
                    $scope.model = data;
                });

                $scope.save = function () {
                    $http.post('<?= Url::to(['update']) ?>', $scope.model, {
                        params: {id: $routeParams.id, }
                    })
                        .success(function (data, status) {
                            if (status == 200) {
                                window.location.hash = '#/view/' + data.id;
                            }
                        });
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

            var addItem = function (item) {
                var has = false;
                var key = 0;
                for (key in $scope.model.details) {
                    var detail = $scope.model.details[key];
                    if (detail.product_id == item.id) {
                        has = true;
                        detail.qty++;
                        break;
                    }
                }
                if (!has) {
                    key = $scope.model.details.length;
                    $scope.model.details.push({
                        product_id: item.id,
                        product: item, qty: 1, price: 0
                    });
                }
                setTimeout(function () {
                    jQuery('tr[data-key="' + key + '"] input[data-field="qty"]').focus().select();
                }, 300);
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
            }
            $scope.subTotal = function(detail){
                return detail.qty * detail.price;
            }
        }
    };

    var dApp = angular.module('dApp', [
        'ngRoute',
        'dControllers',
        'ui.bootstrap',
        'angucomplete',
    ]);

    dApp.config(['$routeProvider',
        function ($routeProvider) {
            $routeProvider.
                when('/view/:id', {
                    templateUrl: '<?= Url::to(['partial', 'view' => 'view']) ?>',
                    controller: 'ViewCtrl'
                }).
                when('/edit/:id', {
                    templateUrl: '<?= Url::to(['partial', 'view' => 'edit']) ?>',
                    controller: 'EditCtrl'
                }).
                when('/create', {
                    templateUrl: '<?= Url::to(['partial', 'view' => 'create']) ?>',
                    controller: 'CreateCtrl'
                }).
                when('/list', {
                    templateUrl: '<?= Url::to(['partial', 'view' => 'list']) ?>',
                    controller: 'ListCtrl'
                }).
                otherwise({
                    redirectTo: '/list',
                });
        }]);
    // controllers
    var dControllers = angular.module('dControllers', []);
    dControllers.controller('ListCtrl', ['$scope', '$http',
        function ($scope, $http) {

            var mapPage = {
                totalItems: 'X-Pagination-Total-Count',
                pageCount: 'X-Pagination-Page-Count',
                currentPage: 'X-Pagination-Current-Page',
                itemPerPage: 'X-Pagination-Per-Page',
            };

            $scope.pager = {maxSize: 5};
            $scope.goto = function (page) {
                $http.get('<?= Url::to(['list']) ?>', {
                    params: {page: page, 'per-page': 5}
                }).success(function (data, status, headers) {
                    $scope.rows = data;
                    $scope.headers = headers;

                    angular.forEach(mapPage, function (val, key) {
                        $scope.pager[key] = headers(val);
                    });
                });
            }
            $scope.pageChange = function () {
                $scope.goto($scope.pager.currentPage);
            }
            $scope.goto();

        }]);

    dControllers.controller('ViewCtrl', ['$scope', '$http', '$routeParams',
        function ($scope, $http, $routeParams) {
            return ns.ctrlFunc.call(this, $scope, $http, $routeParams);
        }]);

    dControllers.controller('EditCtrl', ['$scope', '$http', '$routeParams',
        function ($scope, $http, $routeParams) {
            return ns.ctrlFunc.call(this, $scope, $http, $routeParams);
        }]);

    dControllers.controller('CreateCtrl', ['$scope', '$http',
        function ($scope, $http) {
            return ns.ctrlFunc.call(this, $scope, $http);
        }]);
</script>