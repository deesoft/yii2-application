<?php

namespace app\angular\controllers\inventory;

use Yii;
use yii\web\Controller;

/**
 * PurchaseController implements the CRUD actions for Purchase model.
 */
class MovementController extends Controller
{

    /**
     * Display main page
     * @return mixed
     */
    public function actionIndex($view='index')
    {
        if ($view === 'index') {
            return $this->render('index');
        } else {
            return $this->renderPartial($view);
        }
    }
}