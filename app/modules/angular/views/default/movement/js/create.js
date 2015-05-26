
var $location = $injector.get('$location');
var $routeParams = $injector.get('$routeParams');
var Rest = $injector.get('Rest');
var myFunc = $injector.get('myFunc');

// model
$scope.model = {};

if ($routeParams.reff && $routeParams.id) {
    Rest($routeParams.reff + '/:id/items').query({
        id: $routeParams.id,
        expand: 'product,uom'
    }, function (rows) {
        for (var i in rows) {
            rows[i].avaliable = myFunc.getAvaliable($routeParams.reff, rows[i]);
        }
        $scope.items = rows;
        $scope.freeInputDetail = false;
    });
} else {
    $scope.freeInputDetail = true;
    $scope.items = [];
}

// save Item
$scope.save = function () {
    var post = {};
    if ($scope.model.supplier) {
        post.supplier_id = $scope.model.supplier.id;
    }
    post.date = $scope.model.date;
    post.items = $scope.items;

    Movement.save({}, post, function (model) {
        id = model.id;
        $location.path('/view/' + id);
    }, function (r) {
        $scope.errors = {status: r.status, text: r.statusText, data: {}};
        if (r.status == 422) {
            for (var key in r.data) {
                $scope.errors.data[r.data[key].field] = r.data[key].message;
            }
        }
    });
}

$scope.discard = function () {
    $location.path('/index');
}