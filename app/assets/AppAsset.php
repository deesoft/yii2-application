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
    public $sourcePath = '@app/assets/js';
    public $js = [
        'md5.js',
        'biz-input.js',
    ];
    public $depends = [
        'yii\web\JqueryAsset',
        'dee\angular\AngularAsset',
    ];

    public $publishOptions = [
        'forceCopy'=>true,
    ];
}