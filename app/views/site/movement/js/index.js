var $location = $injector.get('$location');
var search = $location.search();
var $pageInfo = $injector.get('$pageInfo');

query = function () {
    Movement.query({
        page: search.page,
        sort: search.sort,
        expand: 'branch,warehouse',
    }, function (rows, headerCallback) {
        $pageInfo(headerCallback, $scope.provider);
        $scope.rows = rows;
    });
}

// data provider
$scope.provider = {
    sort: search.sort,
    paging: function () {
        search.page = $scope.provider.page;
        $location.search(search);
    },
    sorting: function () {
        search.sort = $scope.provider.sort;
        $location.search(search);
    }
};

// delete Item
$scope.deleteModel = function (model) {
    if (confirm('Are you sure you want to delete')) {
        id = model.id;
        Movement.remove({id: id}, {}, function () {
            query();
        });
    }
}

query();