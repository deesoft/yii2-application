// master
var Master = $injector.get('Master');

$scope.products = Master.products;
$scope.suppliers = Master.suppliers;
$scope.branchs = Master.branchs;
$scope.productUoms = Master.product_uoms;
$scope.errors = {};

jQuery('form').on('keypress change',':input[ng-model]',function(){
    var field = $(this).attr('name');
    if($scope.errors[field]){
        delete $scope.errors[field];
    }
});

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
    for (key in $scope.model.items) {
        var item = $scope.model.items[key];
        if (item.product_id == product.id) {
            has = true;
            item.qty++;
            $scope.itemActive = key;
            break;
        }
    }
    if (!has) {
        key = $scope.model.items.length;
        var uom_id;
        var uoms = $scope.productUoms[product.id];
        if (uoms && uoms[0]) {
            uom_id = uoms[0].id;
        }
        $scope.model.items.push({
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
    for (var key in $scope.model.items) {
        if (key != idx) {
            temp.push($scope.model.items[key])
        }
    }
    $scope.model.items = temp;
    jQuery('#product').focus();
}