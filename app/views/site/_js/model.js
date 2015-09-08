module.config(['$httpProvider', function ($httpProvider) {
        var interceptor = function ($q, $injector) {
            return {
                request: function (config) {
                    if (opts.token === undefined) {
                        //opts.token = localStorage.getItem(TOKEN_KEY);
                    }
                    if (opts.token && config.url.indexOf(baseApiUrl) === 0) {
                        switch (opts.authMethod) {
                            case 'http-bearer':
                                config.headers.Authorization = 'Bearer ' + opts.token;
                                break;

                            case 'query-param':
                            default :
                                config.params = angular.extend(config.params || {}, {'access-token': opts.token});
                                break;
                        }
                    }
                    return config;
                },
                responseError: function (response) {
                    if (response.status == 401) {
                        var deferred = $q.defer();
                        var $modal = $injector.get('$modal');

                        var loginModal = angular.extend({}, module.templates['/user/login'], {
                            animation: true,
                            size: 'sm',
                            backdrop: 'static',
                        });
                        $modal.open(loginModal).result.then(function (token) {
                            opts.token = token;
                            //localStorage.setItem(TOKEN_KEY, opts.token);
                            window.location.reload();
                        }, function () {
                            window.history.back();
                        });
                        return deferred.promise;
                    }
                    return $q.reject(response);
                }
            };
        }
        interceptor.$inject = ['$q', '$injector'];
        $httpProvider.interceptors.push(interceptor);
    }
]);

module.config(['ResourceProvider', function (ResourceProvider) {
        ResourceProvider.defaults.baseUrl = baseApiUrl;
    }]);

// Model
module.factory('Purchase', ['Resource', function (Resource) {
        return Resource('purchase/:id');
    }]);

module.factory('Product', ['Resource', function (Resource) {
        return Resource('product/:id');
    }]);

