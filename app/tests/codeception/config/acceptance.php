<?php
defined('YII_APP_BASE_PATH') or define('YII_APP_BASE_PATH', dirname(dirname(dirname(__DIR__))));
/**
 * Application configuration for acceptance tests
 */
return yii\helpers\ArrayHelper::merge(
    require(YII_APP_BASE_PATH . '/config/common.php'),
    require(YII_APP_BASE_PATH . '/config/common-local.php'),
    require(YII_APP_BASE_PATH . '/config/web.php'),
    require(YII_APP_BASE_PATH . '/config/web-local.php'),
    require(__DIR__ . '/config.php'),
    [
    ]
);
