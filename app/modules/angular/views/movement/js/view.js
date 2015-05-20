
$location = $injector.get('$location');
$routeParams = $injector.get('$routeParams');

$scope.paramId = $routeParams.id;
// model
Movement.get({id: $scope.paramId, expand: 'supplier,branch'}, function (row) {
    $scope.model = row;
});

Movement.query({
    id: $scope.paramId, attribute: 'items',
    expand: 'product,uom'
}, function (rows) {
    $scope.items = rows;
});

// delete Item
$scope.deleteModel = function(){
    if(confirm('Are you sure you want to delete')){
        Movement.remove({id:$scope.paramId},{},function(){
            $location.path('/');
        });
    }
}