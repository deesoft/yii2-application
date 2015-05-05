<?php
/* @var $this yii\web\View */
?>
<div class="btn-group">
    <a class="btn btn-primary btn-sm" href="#/list">List</a>
    <a class="btn btn-danger btn-sm" ng-href="#edit/{{model.id}}">Edit</a>
</div>
<div class="box box-primary">
    <div class="box box-body">
        <div class="row">
            <div class="col-xs-6">
                <div class="form-group field-purchase-number">
                    <label class="control-label">Number</label>
                    <span class="form-control">{{model.number}}</span>

                    <div class="help-block"></div>
                </div>
                <div class="form-group field-purchase-nmsupplier required">
                    <label for="purchase-nmsupplier" class="control-label">Nm Supplier</label>
                    <span class="form-control">{{model.supplier.name}}</span>
                    <div class="help-block"></div>
                </div>
                <div class="form-group field-purchase-nmstatus">
                    <label for="purchase-nmstatus" class="control-label">Nm Status</label>
                    <span class="form-control">{{model.status}}</span>
                    <div class="help-block"></div>
                </div>
            </div>
            <div class="col-xs-6">                
                <div class="form-group field-purchase-date required">
                    <label for="purchase-date" class="control-label">Date</label>
                        <span class="form-control">{{model.date | date:'dd-MM-yyyy'}}</span>
                    <div class="help-block"></div>
                </div>
                <h4 style="display: none; padding-left: 135px;" id="bfore">Rp<span id="purchase-val">0</span>-<span id="disc-val">0</span></h4>         
                <h2 style="padding-left: 133px; margin-top: 0px;">Rp<span id="total-price">0</span></h2>
            </div>
        </div>
    </div>
    <div class="box box-footer">
        <div class="row">
            <div class="col-lg-12">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th><a >Number</a></th>
                            <th><a >Warehouse</a></th>
                            <th><a >Branch</a></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr data-key="{{model.id}}" ng-repeat="(no,model) in rows">
                            <td><a ng-href="#/view/{{model.id}}">{{(pager.currentPage-1)*pager.itemPerPage + no + 1}}</a></td>
                            <td>{{model.number}}</td>
                            <td>{{model.supplier.name}}</td>
                            <td>{{model.branch.name}}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>