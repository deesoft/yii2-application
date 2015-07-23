<?php
defined('YII_APP_BASE_PATH') or define('YII_APP_BASE_PATH', dirname(dirname(dirname(dirname(__DIR__)))));

/**
 * Application configuration for app acceptance tests
 */
return yii\helpers\ArrayHelper::merge(
    require(YII_APP_BASE_PATH . '/common/config/main.php'),
    require(YII_APP_BASE_PATH . '/common/config/main-local.php'),
    require(YII_APP_BASE_PATH . '/app/config/web.php'),
    require(YII_APP_BASE_PATH . '/app/config/web-local.php'),
    require(dirname(__DIR__) . '/config.php'),
    require(dirname(__DIR__) . '/acceptance.php'),
    require(__DIR__ . '/config.php'),
    [
    ]
);
