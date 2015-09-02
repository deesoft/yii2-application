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
    public $enableCsrfValidation = false;
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
        $model->load(Yii::$app->getRequest()->post(), '');
        if ($model->login()) {
            /* @var $user \common\models\User */
            $user = Yii::$app->getUser()->getIdentity();
            return ['token'=>$user->getToken(true)];
        }
        return Yii::createObject('yii\rest\Serializer')->serialize($model);
    }
}