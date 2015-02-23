<?php

use app\components\JsBlock;
use yii\helpers\Url;
use yii\web\View;
use dee\angular\AngularRouteAsset;

/* @var $this yii\web\View */
AngularRouteAsset::register($this);
?>

<div ng-app="dApp"><div ng-view=""></div></div>

<?php JsBlock::begin(['pos' => View::POS_END]) ?>
<script>
    var dApp = angular.module('dApp', [
        'ngRoute',
        'dControllers',
//        'dServices',
    ]);
    dApp.config(['$routeProvider',
        function ($routeProvider) {
            $routeProvider.
                when('/', {
                    templateUrl: '<?= Url::to(['partial', 'view' => 'index']) ?>',
                    controller: 'ListCtrl'
                }).
                when('/:id', {
                    templateUrl: '<?= Url::to(['partial', 'view' => 'view']) ?>',
                    controller: 'ViewCtrl'
                }).
                otherwise({
                    templateUrl: '<?= Url::to(['partial', 'view' => 'index']) ?>',
                    controller: 'ListCtrl'
                });
        }]);

    // controllers
    var dControllers = angular.module('dControllers', []);
    dControllers.controller('ListCtrl', ['$scope', '$http',
        function ($scope, $http) {
            $http.get('<?= Url::to(['list']) ?>').success(function (data) {
                $scope.data = data;
            });
        }]);

    dControllers.controller('ViewCtrl', ['$scope', '$routeParams', '$http',
        function ($scope, $routeParams, $http) {
            $http.get('<?= Url::to(['view']) ?>', {params: {id: $routeParams.id}}).success(function (data) {
                $scope.data = data;
            });
        }]);
</script>
<?php JsBlock::end(); ?>
