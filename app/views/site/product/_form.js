// master
$scope.products = yii.app.master('products');
$scope.suppliers = yii.app.master('suppliers');
$scope.branchs = yii.app.master('branchs');
$scope.productUoms = yii.app.master('product_uoms');
$scope.errors = {data: {}};

// date
$scope.dt = {
    opened: false,
    open: function ($event) {
        $event.preventDefault();
        $event.stopPropagation();
        $scope.dt.opened = true;
    }
}

$scope.itemActive = -1;

$scope.addItem = function (product) {
    var has = false;
    var key = 0;
    for (key in $scope.items) {
        var item = $scope.items[key];
        if (item.product_id == product.id) {
            has = true;
            item.qty++;
            $scope.itemActive = key;
            break;
        }
    }
    if (!has) {
        key = $scope.items.length;
        var uom_id;
        var uoms = $scope.productUoms.get(product.id);
        if (uoms && uoms[0]) {
            uom_id = uoms[0].id;
        }
        $scope.items.push({
            product_id: product.id,
            product: product,
            uom_id: uom_id,
            qty: 1, price: 0
        });
        $scope.itemActive = key;
    }
}

$scope.selectProduct = function (product) {
    $scope.addItem(product);
    $scope.selectedProduct = '';
}

$scope.deleteRow = function (idx) {
    var temp = [];
    for (var key in $scope.items) {
        if (key != idx) {
            temp.push($scope.items[key])
        }
    }
    $scope.items = temp;
    jQuery('#product').focus();
}