
var $location = $injector.get('$location');
var $routeParams = $injector.get('$routeParams');
var $route = $injector.get('$route');

$scope.paramId = $routeParams.id;
// model

query = function () {
    Purchase.get({
        id: $scope.paramId,
        expand: 'supplier,branch,items.product,items.uom,movements.warehouse'
    }, function (row) {
        $scope.model = row;
        $scope.receives = row.movements;
    });
};
query();

// delete Item
$scope.deleteModel = function () {
    if (confirm('Are you sure you want to delete')) {
        Purchase.remove({id: $scope.paramId}, {}, function () {
            window.history.back();
        });
    }
};

// confirm
$scope.confirm = function () {
    if (confirm('Are you sure you want to save')) {
        Purchase.patch({id: $scope.paramId}, [
            {field: 'status', value: 20}
        ], function () {
            $route.reload();
        }, function (err) {
            window.alert(err.data.message)
        });
    }
};

// confirm
$scope.reject = function () {
    if (confirm('Are you sure you want to reject status')) {
        Purchase.patch({id: $scope.paramId}, [
            {field: 'status', value: 10}
        ], function () {
            $route.reload();
        }, function (err) {
            window.alert(err.data.message)
        });
    }
};

$scope.deleteGR = function (item) {
    if (confirm('Are you sure you want to delete')) {
        Movement.remove({id: item.id}, {}, function () {
            query();
        }, function (err) {
            window.alert(err.data.message)
        });
    }
}

$scope.applyGR = function (item) {
    if (confirm('Are you sure you want to save')) {
        Movement.patch({id: item.id}, [
            {field: 'status', value: 20}
        ], function () {
            query();
        }, function (err) {
            window.alert(err.data.message)
        });
    }
}

$scope.rejectGR = function (item) {
    if (confirm('Are you sure you want to reject status')) {
        Movement.patch({id: item.id}, [
            {field: 'status', value: 10}
        ], function () {
            query();
        }, function (err) {
            window.alert(err.data.message)
        });
    }
}

