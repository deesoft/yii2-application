<?php

namespace app\angular;

/**
 * Description of ModuleAssets
 *
 * @author Misbahul D Munir <misbahuldmunir@gmail.com>
 * @since 1.0
 */
class ModuleAsset extends \yii\web\AssetBundle
{
    /**
     * @inheritdoc
     */
    public $sourcePath = '@app/angular/assets';

    /**
     * @inheritdoc
     */
    public $js = [
        'js/module.base.js',
    ];

    /**
     * @inheritdoc
     */
    public $depends = [
        'yii\web\YiiAsset',
        'dee\angular\AngularAsset',
        'dee\angular\AngularBootstrapAsset',
        'dee\angular\AngucompleteAsset'
    ];
}