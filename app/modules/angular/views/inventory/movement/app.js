var masters = masters || {};
var ns = {
    ensureProduct: function (items) {
        angular.forEach(items, function (item) {
            if (!item.product) {
                item.product = masters.products[item.product_id];
            }
        });
    },
    getMaster: function () {
        return {
            products: masters._products,
            suppliers: masters.suppliers,
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
            var url = yii.app.apiPrefix + 'movement/:id';
            return $resource(url, {}, {
                query: {
                    params: {'per-page': 10, expand: 'warehouse', },
                    isArray: true,
                },
                get: {
                    params: {expand: 'warehouse,items', },
                },
                save: {
                    method: 'POST',
                    headers: {'X-CSRF-Token': yii.getCsrfToken()},
                },
                update: {
                    method: 'PUT',
                    headers: {'X-CSRF-Token': yii.getCsrfToken()},
                },
                patch: {
                    method: 'PATCH',
                    headers: {'X-CSRF-Token': yii.getCsrfToken()},
                },
            });
        }
    ])
    .config(['$routeProvider',
        function ($routeProvider) {
            var prefix = yii.app.tplPrefix;
            $routeProvider.
                when('/view/:id', {
                    templateUrl: prefix + 'view',
                    controller: 'ViewCtrl',
                    name: 'view',
                }).
                when('/edit/:id', {
                    templateUrl: prefix + 'edit',
                    controller: 'EditCtrl',
                    name: 'edit',
                }).
                when('/create', {
                    templateUrl: prefix + 'create',
                    controller: 'CreateCtrl',
                    name: 'create',
                }).
                when('/receive/:id', {
                    templateUrl: prefix + 'receive',
                    controller: 'ReceiveCtrl',
                    name: 'receive',
                }).
                when('/list', {
                    templateUrl: prefix + 'list',
                    controller: 'ListCtrl',
                    name: 'list',
                }).
                otherwise({
                    redirectTo: '/list',
                });
        }
    ])
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
                    gotoPage();
                }
            }
        }
    ])
    .controller('ViewCtrl', ['$scope', '$routeParams', 'Resource','$route',
        function ($scope, $routeParams, Resource, $route) {
            $scope.masters = ns.getMaster(Resource);
            $scope.model = ns.getModel(Resource, $routeParams.id);
            
            $scope.apply = function (){
                Resource.patch({id:$routeParams.id},[{field:'status',value:20}],function(){
                    $route.reload();
                });
            }
            $scope.reject = function (){
                Resource.patch({id:$routeParams.id},[{field:'status',value:10}],function(){
                    $route.reload();
                });
            }
        }
    ])
    .controller('CreateCtrl', ['$scope', '$location', '$route', 'Resource',
        function ($scope, $location, $route, Resource) {
            $scope.masters = ns.getMaster();
            var _fields = ['supplier_id', 'date', 'items'];

            $scope.model = new Resource({items: []});

            $scope.save = function () {
                if ($scope.model.supplier) {
                    $scope.model.supplier_id = $scope.model.supplier.id;
                }
                var data = {};
                angular.forEach(_fields, function (field) {
                    data[field] = $scope.model[field];
                });
                Resource.save({id: _id}, data, function (model) {
                    $location.path('/view/' + model.id);
                }, function (error) {

                });
            }

            $scope.discard = function () {
                $location.path('/list/');
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
        }
    ])
    .controller('EditCtrl', ['$scope', '$routeParams', '$location', 'Resource',
        function ($scope, $routeParams, $location, Resource) {
            $scope.masters = ns.getMaster();
            var _fields = ['supplier_id', 'date', 'items'];
            
            $scope.model = ns.getModel(Resource, $routeParams.id);
            $scope.save = function () {
                if ($scope.model.supplier) {
                    $scope.model.supplier_id = $scope.model.supplier.id;
                }
                var data = {};
                angular.forEach(_fields, function (field) {
                    data[field] = $scope.model[field];
                });
                Resource[_action]({id: _id}, data, function (model) {
                    $location.path('/view/' + model.id);
                }, function (error) {

                });
            }

            $scope.discard = function () {
                $location.path('/view/' + $routeParams.id);
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
        }
    ]);

$(function () {
    $(document).on('keypress', 'tr[data-key] :input[data-field]', function (event) {
        if (event.keyCode == 13) {
            var $th = $(this);
            var field = $th.data('field');
            if (field == 'price') {
                $('#product').focus();
            } else {
                var $tr = $th.closest('tr[data-key]');
                if (field == 'qty') {
                    $tr.find(':input[data-field="uom"]').focus();
                } else {
                    $tr.find(':input[data-field="price"]').focus().select();
                }
            }
        }
    });
});