<?php

use app\components\Helper;

/* @var $this yii\web\View */

$masters = [];
foreach (['products', 'suppliers', 'barcodes'] as $name) {
    $method = 'get' . $name;
    $masters[$name] = Helper::$method();
}
$masters['_products'] = array_values($masters['products']);
?>
var masters = <?= json_encode($masters); ?>;