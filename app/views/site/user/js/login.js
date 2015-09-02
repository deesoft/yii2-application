$scope.error = {};

jQuery('form').on('change',':input[name]',function (){
    var $th = jQuery(this);
    delete $scope.error[$th.attr('name')];
});

$scope.login = function(){
    var post = $scope.model;
    
    Auth.login(post,function (){
        $modalInstance.close();
    },function (r){
        if (r.status == 422) {
            angular.forEach(r.data,function(v){
                $scope.error[v.field] = v.message;
            });
        }
    });    
}
