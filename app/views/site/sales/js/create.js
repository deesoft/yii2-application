
$location = $injector.get('$location');

// model
$scope.model = {};
$scope.model.items = [];

// save Item
$scope.save = function () {
    var post = {};
    if ($scope.model.supplier) {
        post.supplier_id = $scope.model.supplier.id;
    }
    post.date = $scope.model.date;
    post.branch_id = $scope.model.branch_id;
    post.items = [];
    
    angular.forEach($scope.model.items,function (item){
        post.items.push({
            product_id:item.product_id,
            qty:item.qty,
            uom_id:item.uom_id,
            price:item.price,
        });
    });

    Sales.save({}, post, function (model) {
        id = model.id;
        $location.path('/sales/' + id);
    }, function (r) {
        $scope.errors = {status: r.status, text: r.statusText, data: {}};
        if (r.status == 422) {
            for (var key in r.data) {
                $scope.errors.data[r.data[key].field] = r.data[key].message;
            }
        }
    });
}

$scope.discard = function (){
    window.history.back();
}