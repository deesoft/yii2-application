
$location = $injector.get('$location');
$routeParams = $injector.get('$routeParams');
var Rest = $injector.get('Rest');

$scope.paramId = $routeParams.id;

// model
Movement.get({
    id: $scope.paramId,
    expand: 'items,reference.items.product,reference.items.uom',
}, function (row) {
    var model = row;

    if (row.reff_type) {
        var config = yii.app.master('mvconfig').get(row.reff_type);
        model.type_name = row.type == 10 ? 'Goods Receipe' : 'Goods Issue';
        model.reff_name = config.name;
        model.reff_number = row.reference.number;
        if (config.client) {
            model.reff_url = config.client;
        } else {
            model.reff_url = config.api;
        }

        var f0 = config.field[0], f1 = config.field[1];
        var items = [];
        angular.forEach(row.reference.items, function (item) {
            item.avaliable = item[f0] - item[f1];
            item.qty = '';
            if(config.value_field){
                item.item_value = item[config.value_field];
            }
            for (var i in model.items) {
                if (item.product_id == model.items[i].product_id) {
                    item.qty = model.items[i].qty;
                    break;
                }
            }
            items.push(item);
        });
        model.items = items;
    }

    if (model.branch_id) {
        model.branch_name = $scope.branchs.get(model.branch_id).name;
    }

    $scope.model = model;
});

// save Item
$scope.save = function () {
    var post = {};
    post.date = $scope.model.date;
    post.warehouse_id = $scope.model.warehouse_id;
    
    if (!$scope.model.reff_type) {
        post.type = $scope.model.type;
    }

    post.items = [];
    angular.forEach($scope.model.items, function (item) {
        if (item.qty != '' && item.qty != '0') {
            post.items.push({
                product_id: item.product_id,
                qty: item.qty,
                item_value: item.item_value,
                uom_id: item.uom_id,
            });
        }
    });
    Movement.update({id: $scope.paramId}, post, function (model) {
        id = model.id;
        $location.path('/movement/' + id);
    }, function (r) {
        $scope.errors = {status: r.status, text: r.statusText, data: {}};
        if (r.status == 422) {
            for (key in r.data) {
                $scope.errors.data[r.data[key].field] = r.data[key].message;
            }
        }
    });
}

$scope.discard = function () {
    window.history.back();
}