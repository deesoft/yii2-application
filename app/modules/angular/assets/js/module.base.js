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

    var pub = {
        apiPrefix: '/dee-app/api/',
        baseUrl: '/dee-app/',
        master: function (name) {
            return local.masters[name];
        },
        getProductByCode: function (code) {
            var products = pub.master('products'),
                barcodes = pub.master('barcodes'),
                id = barcodes.get(code);
            return id ? products.get(id) : undefined;
        },
        initMasters: function (masters) {
            for (var key in masters) {
                local.masters[key] = new DObject(masters[key]);
            }
        }
    };
    return pub;
})(jQuery);