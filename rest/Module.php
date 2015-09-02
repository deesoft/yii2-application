<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace rest;

use Yii;
use yii\base\BootstrapInterface;
use yii\filters\auth\CompositeAuth;
use yii\filters\auth\QueryParamAuth;
use yii\filters\auth\HttpBearerAuth;
use dee\rest\GuestAuth;
use yii\web\Application;

/**
 * Description of Module
 *
 * 
 * @author Misbahul D Munir <misbahuldmunir@gmail.com>
 * @since 1.0
 */
class Module extends \yii\base\Module implements BootstrapInterface
{
    public $prefixUrlRule;

    /**
     * @inheritdoc
     */
    public function beforeAction($action)
    {
        Yii::$app->user->enableSession = false;
        if (parent::beforeAction($action)) {
            if (!Yii::$app->has('bizConfig')) {
                Yii::$app->set('bizConfig', 'rest\classes\Config');
            }

            $request = Yii::$app->getRequest();
            if (empty($request->parsers['application/json'])) {
                $request->parsers['application/json'] = 'yii\web\JsonParser';
            }
            if (Yii::$app->getBehavior('biz') === null) {
                Yii::$app->attachBehavior('biz', 'rest\classes\Hooks');
            }
            return true;
        }
        return false;
    }

    /**
     * @inheritdoc
     */
    public function bootstrap($app)
    {
        if ($app instanceof Application) {
            $app->getUrlManager()->enablePrettyUrl = true;
            $app->getUrlManager()->addRules($this->getUrlRules(), false);
        }
    }

    protected function getUrlRules()
    {
        $prefix = $this->prefixUrlRule === null ? $this->uniqueId : $this->prefixUrlRule;
        $prefixRoute = $this->uniqueId;
        return[
            [
                'class' => 'dee\rest\UrlRule',
                'prefix' => $prefix,
                'prefixRoute' => $prefixRoute,
                'controller' => [
                    'v<version>/<controller>' => 'v<version>/<controller>'
                ]
            ],
        ];
    }

    public function behaviors()
    {
        return[
            'authenticator' => [
                'class' => CompositeAuth::className(),
                'authMethods' => [
                    QueryParamAuth::className(),
                    HttpBearerAuth::className(),
                    GuestAuth::className(),
                ]
            ],
        ];
    }
}