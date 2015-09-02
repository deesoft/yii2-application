<?php

namespace app\assets;

use yii\web\AssetBundle;

/**
 * Description of AppAsset
 *
 * @author Misbahul D Munir <misbahuldmunir@gmail.com>
 * @since 1.0
 */
class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
    ];
    public $js = [
        'js/md5.js'
    ];
    public $depends = [
    ];

}