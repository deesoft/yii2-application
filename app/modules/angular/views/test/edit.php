<?php

use dee\angular\Angular;

/* @var $this yii\web\View */
/* @var $angular Angular */
?>
<div>
    <b>{{id}}</b><br>
    Name : <input type="text" ng-model="item.name"><br>
    Value : <input type="text" ng-model="item.value"><br>
    <button ng-click="save()">Save</button>
    <a href="#/">Cancel</a>
</div>

<?php Angular::beginScript() ?>
<script>
$location = $injector.get('$location');
$routeParams = $injector.get('$routeParams');
Rest = $injector.get('Rest');

$scope.id = $routeParams.id;
$scope.item = Rest.get($scope.id);

$scope.save = function () {
    id = Rest.update($scope.id, $scope.item);
    $location.path('/view/' + $scope.id)
}
</script>
<?php
Angular::endScript();
