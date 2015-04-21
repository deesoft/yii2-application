<?php

namespace app\angular;

/**
 * Description of Module
 *
 * @author Misbahul D Munir <misbahuldmunir@gmail.com>
 * @since 1.0
 */
class Module extends \yii\base\Module implements \yii\base\BootstrapInterface
{

    /**
     * @inheritdoc
     */
    public function bootstrap($app)
    {
        if ($app instanceof \yii\web\Application) {
            $id = $this->id;
            $app->getUrlManager()->addRules([
                'purchase/<template:\w+>' => $id . '/purchase/purchase/index',
                ], false);
        }
    }
}