$scope.error = {};

jQuery('form').on('change',':input[name]',function (){
    var $th = jQuery(this);
    delete $scope.error[$th.attr('name')];
});

$scope.submit = function(){
    var post = $scope.model;
    
    User.save({},post,function(){        
    });
}