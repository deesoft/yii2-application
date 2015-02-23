<?php

namespace app\controllers;

use Yii;
use yii\web\Response;


/**
* MastersController .
 */
class MastersController extends \yii\web\Controller
{

    public function actionIndex(array $masters=[])
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        return \app\components\Helper::getMasters($masters);
    }
}
