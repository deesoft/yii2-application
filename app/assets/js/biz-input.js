(function () {
    var module = angular.module('biz.input', []);

    module.factory('Master',function(){
        var pub = {};
        var _products = MASTERS.products || {};
        var _barcodes = MASTERS.barcodes || {};
        
        pub.products = [];
        angular.forEach(_products,function(v){
            pub.products.push(v);
        });
        
        pub.getProductByCode = function(code){
            var id = _barcodes[code];
            return id ? _products[id] : undefined;
        };
        
        return pub;
    });
    
    module.directive('inputProduct', ['Master',function (Master) {
        return {
            restrict: 'A',
            scope: {
                func: '=inputProduct',
            },
            link: function (scope, element) {
                element.keypress(function (e) {
                    if (e.keyCode == 13) {
                        var code = element.val();
                        var product = Master.getProductByCode(code);
                        if (product) {
                            scope.func(product);
                            element.val('');
                        }
                    }
                });
            }
        };
    }]);

    module.directive('chgFokus', function () {
        return {
            restrict: 'A',
            link: function (scope, element, attrs) {
                scope.$watch(attrs.chgFokus, function (val) {
                    if (val >= 0) {
                        setTimeout(function () {
                            $('tr[data-key="' + val + '"] :input[data-field="qty"]').focus().select();
                            scope[scope.chgFokus] = -1;
                        }, 0);
                    }
                });
                var fields = angular.isDefined(attrs.fields) ? attrs.fields.split(',') : false;
                if (fields) {
                    element.on('keypress', ':input[data-field]', function (e) {
                        if (e.keyCode == 13) {
                            var $th = $(this);
                            var field = $th.data('field');
                            for (var i = 0; i < fields.length; i++) {
                                if (fields[i] == field && fields[i + 1] != undefined) {
                                    element.find(':input[data-field="' + fields[i + 1] + '"]').focus();
                                    return;
                                }
                            }
                            $('#product').focus();
                        }
                    });
                }
            }
        };
    });
})();