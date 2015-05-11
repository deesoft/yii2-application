<?php
/* @var $this yii\web\View */
?>
<div class="btn-group">
    <a class="btn btn-primary btn-sm" ng-click="save()">Save</a>
    <a class="btn btn-danger btn-sm" ng-href="#view/{{model.id}}">Discard</a>
</div>
<div class="box box-primary">
    <div class="box box-body">
        <div class="row">
            <div class="col-xs-6">
                <div class="form-group ">
                    <label class="control-label">Number</label>
                    <span class="form-control">{{model.number}}</span>

                    <div class="help-block"></div>
                </div>
                <div class="form-group required" ng-class="{error:true}">
                    <label class="control-label">Warehouse</label>
                    <input type="text" class="form-control" ng-model="model.warehouse" name="warehouse"
                           typeahead="warehouse as warehouse.name for warehouse in masters.warehouses | filter:$viewValue | limitTo:8">

                    <div class="help-block"></div>
                </div>
            </div>
            <div class="col-xs-6">
                <div class="form-group field-purchase-date required">
                    <label class="control-label">Date</label>
                    <p class="input-group" style="width: 50%;">
                        <input type="text" class="form-control" datepicker-popup="{{dt.format}}"
                               ng-model="model.date" is-open="dt.opened" datepicker-options="dt.dateOptions"
                               ng-focus="dt.open($event)"
                               ng-required="true" close-text="Close" />
                        <span class="input-group-btn">
                            <button type="button" class="btn btn-default" ng-click="dt.open($event)"><i class="glyphicon glyphicon-calendar"></i></button>
                        </span>
                    </p>
                    <div class="help-block"></div>
                </div>
            </div>
        </div>
    </div>
    <div class="box box-footer">
        <div class="row">
            <div class="col-lg-12">
                <table class="tabular table-striped col-lg-12">
                    <thead style="background-color: #9d9d9d;">
                        <tr>
                            <th class="col-lg-4">Product</th>
                            <th class="col-lg-1">Avaliable</th>
                            <th class="col-lg-1">Qty</th>
                            <th class="col-lg-2">Uom</th>
                        </tr>
                    </thead>
                    <tbody id="item-grid">
                        <tr ng-repeat="(idx,item) in items" data-key="{{idx}}">
                            <td >{{item.product.name}}</td>
                            <td >{{item.qty}}</td>
                            <td ><input ng-model="item.qty" class="form-control" data-field="qty"></td>
                            <td >{{item.uom.name}}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>