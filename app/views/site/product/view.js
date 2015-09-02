
var $location = $injector.get('$location');
var $routeParams = $injector.get('$routeParams');
var $route = $injector.get('$route');

$scope.paramId = $routeParams.id;
// model
Purchase.get({id: $scope.paramId, expand: 'supplier,branch'}, function (row) {
    $scope.model = row;
});

Purchase.items({
    id: $scope.paramId,
    expand: 'product,uom'
}, function (rows) {
    $scope.items = rows;
});

// delete Item
$scope.deleteModel = function(){
    if(confirm('Are you sure you want to delete')){
        Purchase.remove({id:$scope.paramId},{},function(){
            $location.path('/purchase/');
        });
    }
}

// confirm
$scope.confirm = function(){
    if(confirm('Are you sure you want save')){
        Purchase.patch({id:$scope.paramId},[
            {field:'status',value:20}
        ],function(){
            $route.reload();
        });
    }
}

// confirm
$scope.reject = function(){
    if(confirm('Are you sure you want reject status')){
        Purchase.patch({id:$scope.paramId},[
            {field:'status',value:10}
        ],function(){
            $route.reload();
        });
    }
}

