<?php
/* @var $this yii\web\View */
?>
<div >
    <form >
        <div class="col-lg-12">
            <div style="min-height: 160px; margin-bottom: 20px; padding-top: 20px;" class="box box-primary">
                <div class="box-body">
                    <div class="col-lg-6">
                        <div class="form-group field-purchase-number">
                            <label for="purchase-number" class="control-label">Number</label>
                            <input type="text" style="width:25%" maxlength="16" ng-model="model.number" readonly="" class="form-control">

                            <div class="help-block"></div>
                        </div>
                        <div class="form-group field-purchase-nmsupplier required">
                            <label for="purchase-nmsupplier" class="control-label">Nm Supplier</label>
                            <input type="text" class="form-control" ng-model="model.supplier"
                                   typeahead="supplier as supplier.name for supplier in masters.suppliers">

                            <div class="help-block"></div>
                        </div>
                        <div class="form-group field-purchase-nmstatus">
                            <label for="purchase-nmstatus" class="control-label">Nm Status</label>
                            <input type="text" style="width:20%" maxlength="16" readonly="" ng-model="model.status" class="form-control">

                            <div class="help-block"></div>
                        </div>
                    </div>
                    <div class="col-lg-6">                
                        <div class="form-group field-purchase-date required">
                            <label for="purchase-date" class="control-label">Date</label>
                            <input type="text" style="width:25%;" value="22/02/2015" class="form-control" ng-model="model.date">
                            <div class="help-block"></div>
                        </div>
                        <h4 style="display: none; padding-left: 135px;" id="bfore">Rp<span id="purchase-val">0</span>-<span id="disc-val">0</span></h4>         
                        <h2 style="padding-left: 133px; margin-top: 0px;">Rp<span id="total-price">0</span></h2>
                    </div>        
                </div>
                <!--    <div class="col-lg-12 footer">                -->
                <!--    </div>-->
            </div>
        </div>
        <div class="col-lg-12">
            <div style="padding: 10px; padding-left: 0px;" class="detail-pane-head col-lg-12">
                <div class="col-xs-10">
                    Product :
                    <input type="text" class="form-control" id="product">
                </div>
                <div class="col-xs-2">
                    Item Discount:
                    <input type="text" class="form-control">
                </div>
            </div>
            <div class="detail-pane-body col-lg-12">
                <table class="tabular table-striped col-lg-12">
                    <thead style="background-color: #9d9d9d;">
                        <tr><th class="col-lg-4">Product</th>
                            <th class="col-lg-1">Qty</th>
                            <th class="col-lg-2">Uom</th>
                            <th class="col-lg-2">@Price</th>

                            <th class="col-lg-2">Sub Total</th>
                            <th class="col-lg-1">&nbsp;</th>
                        </tr>
                    </thead>
                    <tbody id="detail-grid">
                        <tr ng-repeat="detail in model.details">
                            <td >{{detail.product.name}}</td>
                            <td ><input type="number" ng-model="detail.qty" class="form-control"></td>
                            <td ><input type="number" ng-model="detail.uom_id" class="form-control"></td>
                            <td ><input type="number" ng-model="detail.price" class="form-control"></td>
                            <td >{{detail.qty * detail.price}}</td>
                            <td><a>#</a></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </form>
</div>