var $modal = $injector.get('$modal');

$scope.login = function(){
    $modal.open(angular.extend({},module.templates['/user/login'], {
        animation: true,
        size:'sm',
    })).result.then(function () {
        alert('xx');
    });
}