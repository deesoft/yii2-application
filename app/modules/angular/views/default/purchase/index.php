<?php
use dee\angular\Angular;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $angular Angular */

$angular->renderJs('js/index.js');
$angular->requires(['dee.angular']);
?>

<div class="purchase-index">
    <h1><?= Html::encode($this->title) ?></h1>
    <p>
        <?= Html::a('Create', '#/create', ['class' => 'btn btn-success']) ?>
    </p>
    <div class="grid-view">
        <table class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th>#</th>
                    <th><a href="javascript:;" d-sort-provider="provider" sort-field="id">Id</a></th>
                    <th><a href="javascript:;" d-sort-provider="provider" sort-field="number">Number</a></th>
                    <th><a href="javascript:;" d-sort-provider="provider" sort-field="supplier_id">Supplier</a></th>
                    <th><a href="javascript:;" d-sort-provider="provider" sort-field="branch_id">Branch</a></th>
                    <th><a href="javascript:;" d-sort-provider="provider" sort-field="date">Date</a></th>
                    <th><a href="javascript:;" d-sort-provider="provider" sort-field="value">Value</a></th>
                    <th><a href="javascript:;" d-sort-provider="provider" sort-field="discount">Discount</a></th>
                    <th><a href="javascript:;" d-sort-provider="provider" sort-field="status">Status</a></th>
<!--
                    <th><a href="javascript:;" d-sort-provider="provider" sort-field="created_at">Created_at</a></th>
                    <th><a href="javascript:;" d-sort-provider="provider" sort-field="created_by">Created_by</a></th>
                    <th><a href="javascript:;" d-sort-provider="provider" sort-field="updated_at">Updated_at</a></th>
                    <th><a href="javascript:;" d-sort-provider="provider" sort-field="updated_by">Updated_by</a></th>
-->
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <tr ng-repeat="(no,model) in rows">
                    <td>{{(provider.currentPage-1)*provider.itemPerPage + no + 1}}</td>
                    <td>{{model.id}}</td>
                    <td>{{model.number}}</td>
                    <td>{{model.supplier.name}}</td>
                    <td>{{model.branch.name}}</td>
                    <td>{{model.date}}</td>
                    <td>{{model.value}}</td>
                    <td>{{model.discount}}</td>
                    <td>{{model.nmStatus}}</td>
<!--
                    <td>{{model.created_at}}</td>
                    <td>{{model.created_by}}</td>
                    <td>{{model.updated_at}}</td>
                    <td>{{model.updated_by}}</td>
-->
                    <td>
                        <a ng-href="#/view/{{model.id}}"><span class="glyphicon glyphicon-eye-open"></span></a>
                        <a ng-href="#/update/{{model.id}}" ng-if="model.status==10"><span class="glyphicon glyphicon-pencil"></span></a>
                        <a href="javascript:;" ng-click="deleteModel(model)" ng-if="model.status==10"><span class="glyphicon glyphicon-trash"></span></a>
                    </td>
                </tr>
            </tbody>
        </table>
        <pagination total-items="provider.totalItems" ng-model="provider.currentPage"
                    max-size="5" items-per-page="provider.itemPerPage"
                    ng-change="provider.query()"
                    class="pagination-sm" boundary-links="true"></pagination>
    </div>
</div>
