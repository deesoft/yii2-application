<?php

use dee\angular\Angular;

/* @var $this yii\web\View */
/* @var $angular Angular */
?>
<a href="#/create" class="btn btn-success">New Item</a><br>
<table width="100%">
    <thead>
        <tr>
            <th width="10%">ID</th>
            <th width="60%">NAME</th>
            <th></th>
        </tr>
    </thead>
    <tbody>
        <tr ng-repeat="(id,item) in items">
            <td>{{id}}</td>
            <td>{{item.name}}</td>
            <td>
                <a ng-href="#/view/{{id}}"><i class="glyphicon glyphicon-eye-open"></i></a>
                <a ng-href="#/edit/{{id}}"><i class="glyphicon glyphicon-pencil"></i></a>
                <a href="javascript:;" ng-click="deleteItem(id)"><i class="glyphicon glyphicon-trash"></i></a>
            </td>
        </tr>
    </tbody>
</table>

<?php Angular::beginScript() ?>
<script>
Rest = $injector.get('Rest');
$scope.items = Rest.all();
$scope.deleteItem = function (id) {
    Rest.remove(id);
    $scope.items = Rest.all();
}
</script>
<?php
Angular::endScript();
