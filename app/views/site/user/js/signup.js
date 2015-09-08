var $location = $injector.get('$location');
$scope.error = {};

jQuery('form').on('change', ':input[name]', function () {
    var $th = jQuery(this);
    delete $scope.error[$th.attr('name')];
});

$scope.submit = function () {
    var post = $scope.model;

    $http.post(opts.baseApiUrl + 'user/signup', post)
        .then(function () {
            $location.path('/index');
        }, function (r) {
            if (r.status == 422) {
                angular.forEach(r.data, function (v) {
                    $scope.error[v.field] = v.message;
                });
            }
        });
}