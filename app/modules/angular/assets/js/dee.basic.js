Kelas = function () {
    var c = function () {
        if (this.initialize) {
            this.initialize.apply(this, arguments);
        }
    }

    function Extend(dst, src) {
        for (var i in src) {
            try {
                dst[i] = src[i];
            } catch (e) {
            }
        }
        return dst;
    }

    c.prototype = Object.create(Kelas.prototype);
    for (var i = 0; i < arguments.length; i++) {
        var a = arguments[i];
        if (a.prototype) {
            c.prototype = new a();
        } else {
            Extend(c.prototype, a);
        }
    }
    c.prototype.constructor = c;
    Extend(c, c.prototype);
    return c;
}

DObject = (function () {
    return Kelas({
        initialize: function (items) {
            this._items = items;
        },
        _refresh: function () {
            
        },
        _save: function () {
            this._array = undefined;
        },
        all: function () {
            this._refresh();
            return this._items;
        },
        asArray: function () {
            if (this._array === undefined) {
                this._array = [];
                var all = this.all();
                for (var i in all) {
                    this._array.push(all[i]);
                }
            }
            return this._array;
        },
        get: function (id) {
            this._refresh();
            return this._items[id];
        },
        replace: function (items) {
            this._items = items;
            this._save();
        },
        create: function (item, id) {
            this._refresh();
            if (id === undefined) {
                var keys = Object.keys(this._items);
                if(keys.length){
                    last = keys[keys.length - 1];
                    if(last == parseInt(last)){
                        id = parseInt(last) + 1;
                    }else{
                        id = (new Date()).getTime();
                    }
                }else{
                    id = 1;
                }
            }
            this._items[id] = item;
            this._save();
            return id;
        },
        update: function (id, item) {
            this._refresh();
            this._items[id] = item;
            this._save();
        },
        remove: function (id) {
            this._refresh();
            if (this._items[id]) {
                delete this._items[id];
            }
            this._save();
        }
    });
})();

DStorage = (function () {
    var prefixData = 'dee_d_';
    var prefixInfo = 'dee_i_';

    return Kelas(DObject,{
        initialize: function (name) {
            this.name = name;
            this.access = 0;
        },
        attr: function (key, val) {
            var s = localStorage.getItem(prefixInfo + this.name);
            var info = s ? JSON.parse(s) : {lastUpdate: 1};
            if (val === undefined) {
                return info[key];
            } else {
                info[key] = val;
                localStorage.setItem(prefixInfo + this.name, JSON.stringify(info));
            }
        },
        _refresh: function () {
            if (this.access < this.attr('lastUpdate')) {
                var s = localStorage.getItem(prefixData + this.name);
                this._items = s ? JSON.parse(s) : {};
                this._array = undefined;
                this.access = (new Date()).getTime();
                if (this.onChange) {
                    this.onChange();
                }
            }
        },
        _save: function () {
            localStorage.setItem(prefixData + this.name, JSON.stringify(this._items));
            this.access = (new Date()).getTime();
            this.attr('lastUpdate', this.access);
            this._array = undefined;
            if (this.onChange) {
                this.onChange();
            }
        },
    });
})();

DQueue = (function () {
    function push(pushFunc) {
        var th = this;
        pushFunc = pushFunc || th.push;
        if (pushFunc) {
            var items = th.all();
            if (!th.attr('onPush')) {
                var item, key;

                for (key in items) {
                    item = items[key];
                    break;
                }
                if (item !== undefined) {
                    th.attr('onPush', true);
                    th.attr('pushKey', key);

                    pushFunc.call(th, item);
                }
            }
        }
    }
    return Kelas(DStorage, {
        initialize: function (name, callback, interval) {
            DStorage.initialize.call(this, name);
            if (callback !== undefined) {
                this.push = callback;
            }
            this.interval = interval || 1000;

            setInterval(function () {
                push.call(this);
            }, this.interval);
        },
        forcePush: function () {
            push.call(this);
        },
        pushDone: function (type) {
            this.attr('onPush', false);
            if (type) {
                key = this.attr('pushKey');
                this.remove(key);
            }
        }
    });
})();

DMaster = (function () {
    function pull(pullFunc) {
        var th = this;
        pullFunc = pullFunc || th.pull;
        if (pullFunc) {
            if (!th.attr('onPull')) {
                th.attr('onPull', true);

                pullFunc.call(th);
            }
        }
    }
    return Kelas(DStorage, {
        initialize: function (name, callback, interval) {
            DStorage.initialize.call(this, name);
            if (callback !== undefined) {
                this.pull = callback;
            }
            this.interval = interval || 3600000;

            setInterval(function () {
                pull.call(this);
            }, this.interval);

            pull.call(this);
        },
        forcePull: function (pullFunc) {
            pull.call(this, pullFunc);
        },
        pullDone: function (type, items) {
            this.attr('onPull', false);
            if (type) {
                this.replace(items);
            }
        }
    });
})();