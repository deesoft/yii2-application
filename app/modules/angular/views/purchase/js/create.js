
$location = $injector.get('$location');
// model
$scope.model = {};
$scope.items = [];

$scope.errors = {data: {}};

// master
$scope.products = yii.app.masters('products');
$scope.suppliers = yii.app.masters('suppliers');
$scope.productUoms = yii.app.masters('productUoms');

var _fokusKey = -1;
$scope.setFokusQty = function () {
    if (_fokusKey >= 0) {
        jQuery('tr[data-key="' + _fokusKey + '"] input[data-field="qty"]').focus().select();
        _fokusKey = -1;
    }
}

function addItem(product) {
    var has = false;
    var key = 0;
    for (key in $scope.items) {
        var item = $scope.items[key];
        if (item.product_id == product.id) {
            has = true;
            item.qty++;
            _fokusKey = key;
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
        _fokusKey = key;
    }
}

$('#product').off('keypress.create')
    .on('keypress.create',function (e){
        if (e.keyCode == 13) {
        var code = $scope.selectedProduct;
        product = yii.app.getProductByCode(code);
        if (product) {
            addItem(product);
            $scope.selectedProduct = '';
        }
    }
    });

$scope.selectProduct = function (product) {
    addItem(product);
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

// save Item
$scope.save = function () {
    var post = {};
    post.supplier_id = $scope.model.supplier.id;
    post.date = $scope.model.date;
    post.items = $scope.items;

    Purchase.save({}, post, function (model) {
        id = model.id;
        $location.path('/view/' + id);
    }, function (r) {
        $scope.errors = {status: r.status, text: r.statusText, data: {}};
        if (r.status == 422) {
            for (var key in r.data) {
                $scope.errors.data[r.data[key].field] = r.data[key].message;
            }
        }
    });
}