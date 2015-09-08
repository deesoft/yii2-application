$location = $injector.get('$location');

// model
$scope.model = {};
$scope.model.items = [];

// save Item
$scope.save = function () {
    var post = {};
    
    post.code = $scope.model.code;
    post.name = $scope.model.name;
    post.group_id = $scope.model.group_id;
    post.category_id = $scope.model.category_id;

    Product.save({}, post, function (model) {
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