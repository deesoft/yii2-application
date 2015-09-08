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

    Purchase.save({}, post, function (model) {
        id = model.id;
        $location.path('/purchase/' + id);
    }, function (r) {
        $scope.errors = {};
        if (r.status == 422) {
            angular.forEach(r.data,function(v){
                $scope.errors[v.field] = v.message;
            });
        }else{
            
        }
    });
}

$scope.discard = function (){
    window.history.back();
}