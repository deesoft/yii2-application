<?php

namespace app\controllers\master;

use Yii;
use app\models\master\ProductUom;
use app\models\master\searchs\ProductUom as ProductUomSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * ProductUomController implements the CRUD actions for ProductUom model.
 */
class ProductUomController extends Controller
{
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
        ];
    }

    /**
     * Lists all ProductUom models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ProductUomSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single ProductUom model.
     * @param integer $product_id
     * @param integer $uom_id
     * @return mixed
     */
    public function actionView($product_id, $uom_id)
    {
        return $this->render('view', [
            'model' => $this->findModel($product_id, $uom_id),
        ]);
    }

    /**
     * Creates a new ProductUom model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new ProductUom();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'product_id' => $model->product_id, 'uom_id' => $model->uom_id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing ProductUom model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $product_id
     * @param integer $uom_id
     * @return mixed
     */
    public function actionUpdate($product_id, $uom_id)
    {
        $model = $this->findModel($product_id, $uom_id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'product_id' => $model->product_id, 'uom_id' => $model->uom_id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing ProductUom model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $product_id
     * @param integer $uom_id
     * @return mixed
     */
    public function actionDelete($product_id, $uom_id)
    {
        $this->findModel($product_id, $uom_id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the ProductUom model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $product_id
     * @param integer $uom_id
     * @return ProductUom the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($product_id, $uom_id)
    {
        if (($model = ProductUom::findOne(['product_id' => $product_id, 'uom_id' => $uom_id])) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
