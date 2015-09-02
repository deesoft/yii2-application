
$location = $injector.get('$location');
$routeParams = $injector.get('$routeParams');
var $route = $injector.get('$route');

$scope.paramId = $routeParams.id;
// model
Movement.get({id: $scope.paramId, 
    expand: 'warehouse,branch,items.product,items.uom,reference'
}, function (row) {
    if(row.reff_type){
        var config = yii.app.master('mvconfig').get(row.reff_type);
        row.reff_name = config.name;
        row.reff_number = row.reference.number;
        if (config.client) {
            row.reff_url = config.client;
        } else {
            row.reff_url = config.api;
        }
    }
    $scope.model = row;
});

// delete Item
$scope.deleteModel = function(){
    if(confirm('Are you sure you want to delete')){
        Movement.remove({id:$scope.paramId},{},function(){
            window.history.back();
        });
    }
}

// confirm
$scope.apply = function(){
    if(confirm('Are you sure you want to save')){
        Movement.patch({id:$scope.paramId},[
            {field:'status',value:20}
        ],function(){
            $route.reload();
        },function (err){
            window.alert(err.data.message)
        });
    }
}

// confirm
$scope.reject = function(){
    if(confirm('Are you sure you want to reject status')){
        Movement.patch({id:$scope.paramId},[
            {field:'status',value:10}
        ],function(){
            $route.reload();
        },function (err){
            window.alert(err.data.message)
        });
    }
}
