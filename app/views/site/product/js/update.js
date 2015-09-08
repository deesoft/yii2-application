
$location = $injector.get('$location');
$routeParams = $injector.get('$routeParams');

$scope.paramId = $routeParams.id;
// model
Product.get({
    id: $scope.paramId,
}, function (row) {
    $scope.model = row;
});

// save Item
$scope.save = function () {
    var post = {};
    
    post.code = $scope.model.code;
    post.name = $scope.model.name;
    post.group_id = $scope.model.group_id;
    post.category_id = $scope.model.category_id;

    Product.update({id:$scope.paramId}, post, function (model) {
        id = model.id;
        $location.path('/product/' + id);
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