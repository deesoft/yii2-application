module.config(['ResourceProvider', function (ResourceProvider) {
        ResourceProvider.defaults.baseUrl = baseApiUrl;
    }]);

// Model
module.factory('Purchase', ['Resource', function (Resource) {
        return Resource('purchase/:id');
    }]);