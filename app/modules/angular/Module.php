<?php

namespace app\angular;

use Yii;

/**
 * Description of Module
 *
 * @author Misbahul D Munir <misbahuldmunir@gmail.com>
 * @since 1.0
 */
class Module extends \yii\base\Module implements \yii\base\BootstrapInterface
{

    public function init()
    {
        parent::init();
        if (Yii::$app instanceof \yii\web\Application) {
            Yii::$app->getAssetManager()->assetMap['angular/assets/js/master.app.js'] = \yii\helpers\Url::to(['/api/master'], true);
        }
    }

    /**
     * @inheritdoc
     */
    public function bootstrap($app)
    {
        if ($app instanceof \yii\web\Application) {
            
        }
    }
}