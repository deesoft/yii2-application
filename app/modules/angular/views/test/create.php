<?php

use dee\angular\Angular;

/* @var $this yii\web\View */
/* @var $angular Angular */
?>
<div>
    Name : <input type="text" ng-model="item.name"><br>
    Value : <input type="text" ng-model="item.value"><br>
    <button ng-click="save()">Save</button>
</div>

<?php $angular->beginScript() ?>
<script>
$location = $injector.get('$location');
Rest = $injector.get('Rest');
$scope.item = {};
$scope.save = function () {
    id = Rest.save($scope.item);
    $location.path('/view/' + id)
}
</script>
<?php
$angular->endScript();
