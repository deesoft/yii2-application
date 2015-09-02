var opts = options;
var baseApiUrl = options.baseApiUrl;
var TOKEN_KEY = CryptoJS.MD5('d426_angular_token');

module.factory('dHttpInterceptor', ['$q', '$injector',
    function ($q, $injector) {
        var after = {
            retry: function (config, deferred) {
                var $http = $injector.get('$http');
                $http(config).then(function (r) {
                    deferred.resolve(r);
                }, function (r) {
                    deferred.reject(r);
                });
            },
            reload: function () {
                window.location.reload();
            }
        };

        return {
            request: function (config) {
                if (opts.token === undefined) {
                    //opts.token = localStorage.getItem(TOKEN_KEY);
                }
                switch (opts.authMethod) {
                    case 'http-bearer':
                        config.headers.Authorization = 'Bearer ' + opts.token;
                        break;

                    case 'query-param':
                    default :
                        config.params = angular.extend(config.params || {}, {'access-token': opts.token});
                        break;
                }
                return config;
            },
            responseError: function (response) {
                if (response.status == 401) {
                    var deferred = $q.defer();
                    var $modal = $injector.get('$modal');
                    
                    $modal.open(angular.extend({}, module.templates['/user/login'], {
                        animation: true,
                        size: 'sm',
                        backdrop: 'static',
                    })).result.then(function(token){
                        opts.token = token;
                        alert(token);
                        //localStorage.setItem(TOKEN_KEY, opts.token);
                        //after.retry(response.config, deferred);
                    }, function (){});

                    return deferred.promise;
                } else {
                    return response;
                }
            }
        };
    }]);

module.config(['$httpProvider', function ($httpProvider) {
        $httpProvider.interceptors.push('dHttpInterceptor');
    }
]);

module.config(['ResourceProvider', function (ResourceProvider) {
        ResourceProvider.defaults.baseUrl = baseApiUrl;
    }]);

// Model
module.factory('Purchase', ['Resource', function (Resource) {
        return Resource('purchase/:id');
    }]);