yii.app = (function ($) {
    AppMaster = Kelas(DMaster, {
        initialize: function (name) {
            DMaster.initialize.call(this, '_master' + name);
            this.masterName = name;
        },
        pull: function () {
            $.get(pub.baseUrl + 'web/masters', {name: this.masterName}, function (r) {
                this.pullDone(true, r);
            }).fail(function () {
                this.pullDone(false, r);
            });
        }
    });

    AppQueue = Kelas(DQueue, {
        initialize: function (name, url) {
            DQueue.initialize.call(this, '_queue' + name);
            this.queueName = name;
            this.url = url;
        },
        push: function (item) {
            $.post(this.url, item, function () {
                this.pushDone(true);
            }).fail(function () {
                this.pushDone(false);
            });
        }
    });

    var local = {
        masters: {},
    };

        
    var AppStorage = new DStorage('app-storage');
    var pub = {
        apiPrefix: '/dee-app/api/',
        baseUrl: '/dee-app/',
        authDuration: 3600,
        renewAuth: true,
        master: function (name) {
            if (local.masters[name] === undefined) {
                var m = {};
                if ((typeof MASTERS != 'undefined') && (MASTERS[name] != undefined)) {
                    m = MASTERS[name];
                }
                local.masters[name] = new DObject(m);
            }
            return local.masters[name];
        },
        getProductByCode: function (code) {
            var products = pub.master('products'),
                barcodes = pub.master('barcodes'),
                id = barcodes.get(code);
            return id ? products.get(id) : undefined;
        },
        login: function (token, duration) {
            if (duration !== undefined) {
                pub.authDuration = duration;
            }
            var time = (new Date()).getTime() + pub.authDuration * 1000;
            AppStorage.set({tokenValue: token, tokenTime: time})
        },
        getToken: function () {
            var token = AppStorage.get('tokenValue'),
                time = AppStorage.get('tokenTime');
            if (token && time && (time > (new Date()).getTime())) {
                if (pub.renewAuth) {
                    pub.login(token);
                }
                return token;
            }
        },
        isAbsolutePath: function (path) {
            var RE = new RegExp('^(?:[a-z]+:/)?/', 'i');
            return RE.test(path);
        },
    };
    return pub;
})(jQuery);