<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\api;

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
            $app->getUrlManager()->addRules([
                [
                    'class' => 'dee\rest\UrlRule',
                    'routePrefix' => $this->id,
                    'prefix' => 'api',
                    'controller' => [
                        'purchase' => 'purchase/purchase',
                        '<reff:\w+>/<reff_id:\d+>/movements' => 'inventory/movement',
                    ]
                ],
                ], false);
        }
    }
}