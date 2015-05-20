(function () {
    app = angular.module('app.angular', ['ngResource']);

    app.provider('Rest', function () {
        var provider = this;
        
        this.defaults = {
            // Default actions configuration
            actions: {
                update: {method: 'PUT'},
                patch: {method: 'PATCH'},
            },
            paramDefaults: {}
        };

        this.$get = ['$resource', function ($resource) {

                function rest(path, paramDefaults, actions, options) {
                    if (!yii.app.isAbsolutePath(path)) {
                        path = yii.app.apiPrefix + path;
                    }

                    paramDefaults = angular.extend({}, {
                        'access-token': yii.app.getToken(),
                    }, provider.defaults.paramDefaults, paramDefaults);

                    actions = angular.extend({}, provider.defaults.actions, actions);
                    for(var i in actions){
                        if(actions[i].url && !yii.app.isAbsolutePath(actions[i].url)){
                            actions[i].url = yii.app.apiPrefix + actions[i].url;
                        }
                    }
                    return $resource(path, paramDefaults, actions, options);
                }

                return rest;
            }];
    });
    
    
})();