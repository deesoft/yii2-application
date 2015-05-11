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
            $app->getUrlManager()->addRules($this->getUrlRules(), false);
        }
    }

    protected function getUrlRules()
    {
        return[
            [
                'class' => 'dee\rest\UrlRule',
                'tokens' => [
                    '{id}' => '<id:\\d[\\d,]*>',
                    '{attr}' => '<attribute:\\w+>',
                ],
                'extraPatterns' => [
                    'GET,HEAD {id}/{attr}' => 'view',
                ],
                'prefixRoute' => $this->id,
                'prefix' => 'api',
                'controller' => [
                    'purchase' => 'purchase/purchase',
                    'movement' => 'inventory/movement',
                ]
            ],
        ];
    }
}