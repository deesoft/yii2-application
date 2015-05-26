<?php

namespace app\angular\controllers;

use Yii;
use yii\web\Controller;

/**
 * DefaultController implements the CRUD actions for Purchase model.
 */
class DefaultController extends Controller
{

    /**
     * Display main page.
     * @return mixed
     */
    public function actionIndex()
    {
        return $this->render('main');
    }
}
