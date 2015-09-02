<?php

namespace rest\controllers\v1;

use Yii;
use yii\web\Controller;
use app\models\LoginForm;

/**
 * Site controller
 * Just test commit
 */
class SiteController extends Controller
{

    public function actionLogin()
    {
        if(Yii::$app->user->identity !== null){
            return ['access_token' => Yii::$app->user->identity->getAuthKey()];
        }
        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post(), '') && $model->login()) {
            return ['access_token' => Yii::$app->user->identity->getAuthKey()];
        } else {
            return $model;
        }
    }
}