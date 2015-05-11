<div class="box box-body">
    <div class="row">
        <div class="col-xs-6">
            <div class="form-group ">
                <label for="number" class="control-label">Number</label>
                <span class="form-control">{{model.number}}</span>

                <div class="help-block"></div>
            </div>
            <div class="form-group required" ng-class="{error:true}">
                <label for="purchase-nmsupplier" class="control-label">Nm Supplier</label>
                <input type="text" class="form-control" ng-model="model.supplier" name="supplier"
                       typeahead="supplier as supplier.name for supplier in masters.suppliers | filter:$viewValue | limitTo:8">

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
            <h4 style="display: none; padding-left: 135px;" id="bfore">Rp<span id="purchase-val">0</span>-<span id="disc-val">0</span></h4>
            <h2 style="padding-left: 133px; margin-top: 0px;">Rp<span id="total-price">0</span></h2>
        </div>
    </div>
</div>