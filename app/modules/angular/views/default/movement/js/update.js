
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

// save Item
$scope.save = function () {
    Movement.update({id: $scope.paramId}, $scope.model, function (model) {
        id = model.id;
        $location.path('/view/' + id);
    }, function (r) {
        $scope.errors = {status: r.status, text: r.statusText, data: {}};
        if (r.status == 422) {
            for (key in r.data) {
                $scope.errors.data[r.data[key].field] = r.data[key].message;
            }
        }
    });
}

$scope.discard = function (){
    $location.path('/view/' + $scope.paramId);
}