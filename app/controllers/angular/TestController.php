<?php

namespace app\controllers\angular;

use Yii;
use dee\angular\tools\DataSource;
use app\models\master\Product;

/**
 * TestController .
 */
class TestController extends \yii\web\Controller
{
    public function actionIndex()
    {
        return $this->render('main');
    }

    public function actionPartial($view = 'index')
    {
        return $this->renderPartial($view);
    }

    public function actionSave($id = null)
    {
        Yii::$app->response->format = 'json';
        $model = ($id === null) ? new Product() : Product::findOne($id);
        $model->load(Yii::$app->request->post(), '');
        $model->save();
        return $model;
    }

    public function actionDelete($id)
    {
        Yii::$app->response->format = 'json';
        return Product::findOne($id)->delete();
    }

    public function actionList()
    {
        Yii::$app->response->format = 'json';
        $dataSource = new DataSource([
            'query' => Product::find(),
        ]);
        return $dataSource->search(Yii::$app->request->getQueryParams());
    }

    public function actionView($id)
    {
        Yii::$app->response->format = 'json';
        return Product::findOne($id);
    }
}