<?php

namespace app\controllers\master;

use Yii;
use app\models\master\Price;
use app\models\master\searchs\Price as PriceSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\models\purchase\Purchase;
use app\models\master\ProductPrice;
use app\models\master\PriceCategory;
use app\models\purchase\searchs\Purchase as PurchaseSearch;

/**
 * PriceController implements the CRUD actions for Price model.
 */
class PriceController extends Controller
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
     * Lists all Price models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new PriceSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Price model.
     * @param integer $product_id
     * @param integer $price_category_id
     * @return mixed
     */
    public function actionView($product_id, $price_category_id)
    {
        return $this->render('view', [
                'model' => $this->findModel($product_id, $price_category_id),
        ]);
    }

    /**
     * Creates a new Price model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Price();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'product_id' => $model->product_id, 'price_category_id' => $model->price_category_id]);
        } else {
            return $this->render('create', [
                    'model' => $model,
            ]);
        }
    }

    public function actionListPo()
    {
        $searchModel = new PurchaseSearch([
            'status' => Purchase::STATUS_PROCESS
        ]);
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->getSort()->defaultOrder = [
            'date' => SORT_DESC,
            'number' => SORT_DESC
        ];
        return $this->render('list_po', [
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Creates a new Price model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreateByPo($id)
    {
        if (($purchase = Purchase::findOne($id)) === null) {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
        $products = [];
        foreach ($purchase->getPurchaseDtls()->with('product.category')->all() as $detail) {
            $product = new ProductPrice([
                'id' => $detail->product_id,
                'name' => $detail->product->name,
                'category' => $detail->product->category->name,
                'price' => $detail->price,
            ]);
            $products[$detail->product_id] = $product;
        }
        if (ProductPrice::loadMultiple($products, Yii::$app->request->post()) && ProductPrice::validateMultiple($products)) {
            $transaction = Yii::$app->db->beginTransaction();
            try {
                $success = true;
                foreach ($products as $product) {
                    if (!$product->save(false)) {
                        $success = false;
                        break;
                    }
                }
                if ($success) {
                    $transaction->commit();
                    return $this->redirect(['list-po']);
                } else {
                    $transaction->rollBack();
                }
            } catch (\Exception $exc) {
                $transaction->rollBack();
                throw $exc;
            }
        }

        return $this->render('create_by_po', [
                'products' => $products,
                'categories' => PriceCategory::find()->all()
        ]);
    }

    /**
     * Updates an existing Price model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $product_id
     * @param integer $price_category_id
     * @return mixed
     */
    public function actionUpdate($product_id, $price_category_id)
    {
        $model = $this->findModel($product_id, $price_category_id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'product_id' => $model->product_id, 'price_category_id' => $model->price_category_id]);
        } else {
            return $this->render('update', [
                    'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Price model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $product_id
     * @param integer $price_category_id
     * @return mixed
     */
    public function actionDelete($product_id, $price_category_id)
    {
        $this->findModel($product_id, $price_category_id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Price model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $product_id
     * @param integer $price_category_id
     * @return Price the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($product_id, $price_category_id)
    {
        if (($model = Price::findOne(['product_id' => $product_id, 'price_category_id' => $price_category_id])) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
