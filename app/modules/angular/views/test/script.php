<script>
    dApp.factory('Rest', function () {
        var NAME = '_test';
        var s = localStorage.getItem(NAME);
        var items = s ? JSON.parse(s) : {};
        
        return {
            all: function () {
                return items;
            },
            get: function (id) {
                return items[id];
            },
            save: function (item) {
                var keys = Object.keys(items);
                var id = 1;
                if(keys.length){
                    id = keys[keys.length-1]*1 + 1;
                }
                items[id] = item;
                localStorage.setItem(NAME,JSON.stringify(items));
                return id;
            },
            update: function (id, item) {
                items[id] = item;
                localStorage.setItem(NAME,JSON.stringify(items));
            },
            remove: function (id){
                delete items[id];
                localStorage.setItem(NAME,JSON.stringify(items));
            }
        };
    });
</script>