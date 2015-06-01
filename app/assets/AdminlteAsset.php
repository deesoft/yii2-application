<?php

namespace app\assets;

/**
 * AdminLteAsset
 *
 * @author Misbahul D Munir <misbahuldmunir@gmail.com>
 * @since 1.0
 */
class AdminlteAsset extends \yii\web\AssetBundle
{
    public $sourcePath = '@bower/adminlte/dist';
    public $css = [
        'css/AdminLTE.css',
        'css/skins/_all-skins.min.css'
    ];
    public $js = [
        'js/app.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapPluginAsset',
        'rmrevin\yii\fontawesome\AssetBundle',
    ];

}