<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\api;

use Yii;

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
    public function beforeAction($action)
    {
        if (parent::beforeAction($action)) {
            $definitions = require(__DIR__ . '/definitions.php');
            foreach ($definitions as $name => $definition) {
                Yii::$container->set($name, $definition);
            }

            $hooks = require(__DIR__ . '/hooks.php');
            Yii::$app->attachBehaviors(array_combine($hooks, $hooks));
            return true;
        }
        return false;
    }

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
                    '{id}/{attr}',
                ],
                'prefixRoute' => $this->id,
                'prefix' => 'api',
                'actions' => [
                    'purchase' => 'purchase/index',
                    'movement' => 'movement/index',
                ]
            ],
        ];
    }
}