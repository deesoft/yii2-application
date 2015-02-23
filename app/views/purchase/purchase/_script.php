<?php

use yii\helpers\Url;

/* @var $this yii\web\View */
?>
<script>
    var dApp = angular.module('dApp', [
        'ngRoute',
        'dControllers',
        'ui.bootstrap',
    ]);

    var globalData = globalData || {};

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
                when('/:page', {
                    templateUrl: '<?= Url::to(['partial', 'view' => 'list']) ?>',
                    controller: 'ListCtrl'
                }).
                otherwise({
                    templateUrl: '<?= Url::to(['partial', 'view' => 'list']) ?>',
                    controller: 'ListCtrl'
                });
        }]);
    // controllers
    var dControllers = angular.module('dControllers', []);
    dControllers.controller('ListCtrl', ['$scope', '$http', '$routeParams',
        function ($scope, $http, $routeParams) {
            $http.get('<?= Url::to(['list']) ?>', {
                params: {page: $routeParams.page}
            }).success(function (data, status, headers) {
                $scope.rows = data;
                $scope.status = status;
                $scope.headers = headers;
            });
        }]);
    dControllers.controller('ViewCtrl', ['$scope', '$http', '$routeParams',
        function ($scope, $http, $routeParams) {
            $http.get('<?= Url::to(['view']) ?>', {
                params: {
                    id: $routeParams.id,
                    expand: 'details,supplier,branch'
                }
            }).success(function (data) {
                $scope.model = data;
            });
        }]);
    dControllers.controller('EditCtrl', ['$scope', '$http', '$routeParams',
        function ($scope, $http, $routeParams) {
            $http.get('<?= Url::to(['view']) ?>', {
                params: {
                    id: $routeParams.id,
                    expand: 'details,supplier,branch'
                }
            }).success(function (data) {
                $scope.model = data;
            });

            $scope.save = function () {
                $http.post('<?= Url::to(['update']) ?>', $scope.model, {
                    params: {
                        id: $routeParams.id,
                    }
                });
            }

            $http.get('<?= Url::to(['/masters']) ?>', {
                params: {masters: ['products', 'suppliers']}
            }).success(function (masters) {
                $scope.masters = masters;
            });
            
        }]);
    dControllers.controller('CreateCtrl', ['$scope', '$http',
        function ($scope, $http) {
            $scope.model = {
                number: 'xxx',
                date: '2015-02-01'
            };

            $scope.save = function () {
                $http.post('<?= Url::to(['create']) ?>', $scope.model);
            }

            $http.get('<?= Url::to(['/masters']) ?>', {
                params: {masters: ['products', 'suppliers']}
            }).success(function (masters) {
                $scope.masters = masters;
            });
        }]);
</script>