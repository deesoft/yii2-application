<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use common\models\Login;

/**
 * Site controller
 */
class SiteController extends Controller
{

    /**
     * Displays homepage.
     *
     * @return mixed
     */
    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionLogin()
    {
        Yii::$app->getResponse()->format = 'json';
        $model = new Login();
        if ($model->load(Yii::$app->getRequest()->post(), '') && $model->login()) {
            /* @var $user \common\models\User */
            $user = Yii::$app->getUser()->getIdentity();
            return $user->getToken(true);
        }
        return Yii::createObject('yii\rest\Serializer')->serialize($model);
    }
}