<?php

namespace app\angular\controllers;

use Yii;
use yii\web\Controller;

/**
 * PurchaseController implements the CRUD actions for Purchase model.
 */
class MovementController extends Controller
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
