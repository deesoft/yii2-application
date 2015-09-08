// master
var Master = $injector.get('Master');

$scope.productGroups = Master.product_groups;
$scope.categories = Master.categories;
$scope.errors = {};

jQuery('form').on('keypress change',':input[ng-model]',function(){
    var field = $(this).attr('name');
    if($scope.errors[field]){
        delete $scope.errors[field];
    }
});
