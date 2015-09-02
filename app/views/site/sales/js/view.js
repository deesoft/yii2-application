
var $location = $injector.get('$location');
var $routeParams = $injector.get('$routeParams');
var $route = $injector.get('$route');

$scope.paramId = $routeParams.id;
// model

query = function () {
    Sales.get({
        id: $scope.paramId,
        expand: 'customer,branch,items.product,items.uom,movements.warehouse'
    }, function (row) {
        $scope.model = row;
        $scope.issues = row.movements;
    });
};
query();

// delete Item
$scope.deleteModel = function () {
    if (confirm('Are you sure you want to delete')) {
        Sales.remove({id: $scope.paramId}, {}, function () {
            window.history.back();
        });
    }
};

// confirm
$scope.confirm = function () {
    if (confirm('Are you sure you want to save')) {
        Sales.patch({id: $scope.paramId}, [
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
        Sales.patch({id: $scope.paramId}, [
            {field: 'status', value: 10}
        ], function () {
            $route.reload();
        }, function (err) {
            window.alert(err.data.message)
        });
    }
};

$scope.deleteGI = function (item) {
    if (confirm('Are you sure you want to delete')) {
        Movement.remove({id: item.id}, {}, function () {
            query();
        }, function (err) {
            window.alert(err.data.message)
        });
    }
}

$scope.applyGI = function (item) {
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

$scope.rejectGI = function (item) {
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

