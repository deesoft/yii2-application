var $routeParams = $injector.get('$routeParams');
$scope.paramId = $routeParams.id;
// model

query = function () {
    Product.get({
        id: $scope.paramId,
        expand: 'category,group'
    }, function (row) {
        $scope.model = row;
    });
};
query();

// delete Item
$scope.deleteModel = function () {
    if (confirm('Are you sure you want to delete')) {
        Product.remove({id: $scope.paramId}, {}, function () {
            window.history.back();
        });
    }
};
