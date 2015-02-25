<?php

namespace app\controllers;

use Yii;
use yii\web\Response;

/**
 * MastersController .
 */
class MastersController extends \yii\web\Controller
{

    public function actionIndex($masters)
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $masters = preg_split('/\s*,\s*/', trim($masters), -1, PREG_SPLIT_NO_EMPTY);
        $result = [];
        foreach ($masters as $master) {
            $method = 'get' . $master;
            $result[$master] = call_user_func(['app\components\Helper', $method]);
        }
        return $result;
    }
}