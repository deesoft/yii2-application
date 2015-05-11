<?php

use dee\angular\Angular;

/* @var $this yii\web\View */
?>

<?=
Angular::widget([
    'routes' => [
        '/' => [
            'view' => 'index',
            'controller' => 'IndexCtrl', // optional
        ],
        '/view/:id' => [
            'view' => 'view',
            'di' => [],
        ],
        '/edit/:id' => [
            'view' => 'edit',
            'di' => [],
        ],
        '/create' => [
            'view' => 'create',
            'di' => [],
        ],
    ]
])?>
<?php
$js = <<<JS
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
JS;

$this->registerJs($js, \yii\web\View::POS_END);