<?php

namespace app\angular\controllers;

/**
 * Description of TestController
 *
 * @author Misbahul D Munir <misbahuldmunir@gmail.com>
 * @since 1.0
 */
class TestController extends \yii\web\Controller
{
    public function actionIndex()
    {
        return $this->render('bootstrap');
    }
}