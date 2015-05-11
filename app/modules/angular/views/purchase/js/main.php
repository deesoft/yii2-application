<?php

use dee\angular\Angular;
use app\angular\components\Helper;
use yii\helpers\Json;

/* @var $this yii\web\View */
/* @var $angular Angular */

$names = ['products', 'barcodes', 'productUoms', 'suppliers'];

$masters = [];
foreach ($names as $name) {
    $method = 'get' . $name;
    $masters[$name] = Helper::$method();
}
?>
<script>
    yii.app.initMasters(<?= Json::htmlEncode($masters); ?>);
</script>