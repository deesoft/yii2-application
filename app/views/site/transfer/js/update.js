
$location = $injector.get('$location');
$routeParams = $injector.get('$routeParams');

$scope.paramId = $routeParams.id;
// model
Transfer.get({
    id: $scope.paramId, 
    expand: 'items.product,items.uom'
}, function (row) {
    $scope.model = row;
});

// save Item
$scope.save = function () {
    var post = {};
    post.date = $scope.model.date;
    post.branch_id = $scope.model.branch_id;
    post.branch_dest_id = $scope.model.branch_dest_id;
    post.items = [];
    
    angular.forEach($scope.model.items,function (item){
        post.items.push({
            product_id:item.product_id,
            qty:item.qty,
            uom_id:item.uom_id,
        });
    });
    
    Transfer.update({id: $scope.paramId}, post, 
    function (model) {
        id = model.id;
        $location.path('/transfer/view/' + id);
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