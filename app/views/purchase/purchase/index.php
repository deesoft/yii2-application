<?php

use app\components\JsBlock;
use yii\web\View;
use dee\angular\AngularRouteAsset;
use dee\angular\AngularBootstrapAsset;
use dee\angular\AngucompleteAsset;

/* @var $this yii\web\View */
AngularRouteAsset::register($this);
AngularBootstrapAsset::register($this);
AngucompleteAsset::register($this);
?>
<?php JsBlock::widget(['pos' => View::POS_END, 'viewFile' => '_script']) ?>
<?php JsBlock::begin() ?>
<script>
    $(document).on('keypress', 'tr[data-key] :input[data-field]', function (event) {
        if (event.keyCode == 13) {
            var $th = $(this);
            var field = $th.data('field');
            if (field == 'price') {
                $('#product').focus();
            } else {
                var $tr = $th.closest('tr[data-key]');
                if (field == 'qty') {
                    $tr.find(':input[data-field="uom"]').focus();
                } else {
                    $tr.find(':input[data-field="price"]').focus().select();
                }
            }
        }
    });
</script>
<?php JsBlock::end(); ?>

<div ng-app="dApp"><div ng-view=""></div></div>
