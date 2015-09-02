
var $location = $injector.get('$location');
var $routeParams = $injector.get('$routeParams');
var Rest = $injector.get('Rest');

// model
if ($routeParams.reff && $routeParams.id) {
    var reff_type = $routeParams.reff,
    config = yii.app.master('mvconfig').get(reff_type),
    reff_id = $routeParams.id;
    
    Rest(config.api + '/:id').get({
        id: reff_id,
        expand: 'items.product,items.uom'
    }, function (row) {
        var model = {};

        if (config.branch) {
            model.branch_id = row[config.branch];
        } else {
            model.branch_id = row.branch_id;
        }
        if (model.branch_id) {
            model.branch_name = $scope.branchs.get(model.branch_id).name;
        }

        model.type = config.type;
        model.type_name = config.type == 10 ? 'Goods Receipe' : 'Goods Issue';
        model.reff_type = reff_type;
        model.reff_name = config.name;
        model.reff_number = row.number;
        model.reff_id = reff_id;
        if(config.client){
            model.reff_url = config.client;
        }else{
            model.reff_url = config.api;
        }
        
        model.items = [];

        var f0 = config.field[0], f1 = config.field[1];
        angular.forEach(row.items, function (item) {
            item.avaliable = item[f0] - item[f1];
            item.qty = '';
            if(config.value_field){
                item.item_value = item[config.value_field];
            }
            model.items.push(item);
        });
        
        $scope.model = model;
    },function (){
        window.alert('Not Found');
        window.history.back();
    });
    
    $scope.allowInputDetail = false;
} else {
    $scope.allowInputDetail = true;

    $scope.model = {
        items: []
    };
}

// save Item
$scope.save = function () {
    var post = {};
    post.date = $scope.model.date;
    post.warehouse_id = $scope.model.warehouse_id;
    post.type = $scope.model.type;
    if ($scope.model.reff_type) {
        post.reff_type = $scope.model.reff_type;
        post.reff_id = $scope.model.reff_id;
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

    Movement.save({}, post, function (model) {
        id = model.id;
        $location.path('/movement/' + id);
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
    window.history.back();
}