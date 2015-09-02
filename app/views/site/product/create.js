
$location = $injector.get('$location');

// model
$scope.model = {};
$scope.items = [];

// save Item
$scope.save = function () {
    var post = {};
    if ($scope.model.supplier) {
        post.supplier_id = $scope.model.supplier.id;
    }
    post.date = $scope.model.date;
    post.branch_id = $scope.model.branch_id;
    post.items = [];
    
    angular.forEach($scope.items,function (item){
        var r = angular.copy(item);
        delete r.product;
        post.items.push(r);
    });

    Purchase.save({}, post, function (model) {
        id = model.id;
        $location.path('/purchase/view/' + id);
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
    $location.path('/purchase');
}