
$location = $injector.get('$location');
$routeParams = $injector.get('$routeParams');

$scope.paramId = $routeParams.id;
// model
Purchase.get({
    id: $scope.paramId, 
    expand: 'supplier,branch,items.product,items.uom'
}, function (row) {
    $scope.model = row;
});

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
    
    Purchase.update({id: $scope.paramId}, post, 
    function (model) {
        id = model.id;
        $location.path('/purchase/' + id);
    }, function (r) {
        $scope.errors = {status: r.status, text: r.statusText, data: {}};
        if (r.status == 422) {
            for (key in r.data) {
                $scope.errors.data[r.data[key].field] = r.data[key].message;
            }
        }
    });
}

$scope.discard = function (){
    window.history.back();
}