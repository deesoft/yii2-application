
$location = $injector.get('$location');
$routeParams = $injector.get('$routeParams');

$scope.paramId = $routeParams.id;
// model
Purchase.get({id:$scope.paramId},function(row){
    $scope.model = row;
});
$scope.errors = {};

// save Item
$scope.save = function(){
    Purchase.update({id:$scope.paramId},$scope.model,function(model){
        id = model.id;
        $location.path('/view/' + id);
    },function(r){
        $scope.errors = {status: r.status, text: r.statusText, data: {}};
        if (r.status == 422) {
            for (key in r.data) {
                $scope.errors.data[r.data[key].field] = r.data[key].message;
            }
        }
    });
}