<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\assets;

use yii\web\AssetBundle;

/**
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class AppAsset extends AssetBundle
{
    public $sourcePath = '@bower/admin-lte';
    public $css = [
        'css/bootstrap.min.css',
        'css/font-awesome.min.css',
        'css/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css',
        'css/AdminLTE.css'
    ];
    public $js = [
        'js/bootstrap.min.js',
        'js/AdminLTE/app.js',
        //'js/plugins/fullcalendar/fullcalendar.min.js'
        //'js/AdminLTE/demo.js'
    ];
    public $depends = [
        'yii\web\YiiAsset',
    ];
}
