<div class="box box-footer">
    <div class="row">
        <div class="col-lg-12">
            <div class="row">
                <div class="col-xs-10">
                    Product :
                    <input type="text" class="form-control" ng-model="selectedProduct" id="product"
                           input-product="addItem"
                           typeahead="product as product.name for product in products.asArray() | filter:$viewValue | limitTo:8"
                           typeahead-on-select="selectProduct($item)"
                           >
                </div>
                <div class="col-xs-2">
                    Item Discount:
                    <input type="text" class="form-control" name="diskon" >
                </div>
            </div>
        </div>
        <div class="col-lg-12">
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
                <tbody id="item-grid">
                    <tr ng-repeat="(idx,item) in items" data-key="{{idx}}" chg-fokus="itemActive">
                        <td >{{item.product.name}}</td>
                        <td ><input ng-model="item.qty" class="form-control" data-field="qty"></td>
                        <td ><select ng-model="item.uom_id" class="form-control" data-field="uom"
                                     ng-options="uom.id as uom.name for uom in productUoms.get(item.product_id)">
                            </select></td>
                        <td ><input ng-model="item.price" class="form-control" data-field="price"></td>
                        <td style="text-align: right;">{{item.qty * item.price| number}}</td>
                        <td style="text-align: center;"><a href="javascript:;" ng-click="deleteRow(idx)"><i class="glyphicon glyphicon-trash"></i></a></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>