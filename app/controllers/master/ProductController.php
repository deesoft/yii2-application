<?php

namespace app\controllers\master;

use Yii;
use app\models\master\Product;
use app\models\master\searchs\Product as ProductSearch;
use app\models\master\searchs\ProductPrice as ProductPriceSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use mdm\report\BirtReport;

/**
 * ProductController implements the CRUD actions for Product model.
 */
class ProductController extends Controller {

    public function behaviors() {
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
     * Lists all Product models.
     * @return mixed
     */
    public function actionIndex() {
        $searchModel = new ProductSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    public function actionPrintHtml() {
        $pro_rpt = new BirtReport();
        $pro_rpt->reportPath = '@app/reports';

        /* Html output */
        $result = $pro_rpt->renderReport('master_product.rptdesign');
        echo $result;
    }

    public function actionPrintPdf() {
        $pro_rpt = new BirtReport();
        $pro_rpt->reportPath = '@app/reports';

        /* Pdf output */
        Yii::$app->response->format = 'raw';
        Yii::$app->response->getHeaders()->add('Content-type', 'application/pdf');
        return $pro_rpt->renderReport('master_product.rptdesign', [], BirtReport::OUTPUT_TYPE_PDF);
    }

    public function actionPrintXsl() {
        $pro_rpt = new BirtReport();
        $pro_rpt->reportPath = '@app/reports';

        /* xsl output */
        Yii::$app->response->format = 'raw';
        Yii::$app->response->setDownloadHeaders('product_list.xls','Content-type: application/vnd.ms-excel');
        return $pro_rpt->renderReport('master_product.rptdesign', [], BirtReport::OUTPUT_TYPE_XLS);
    }

    /**
     * Lists all Product models.
     * @return mixed
     */
    public function actionPrices() {
        $searchModel = new ProductPriceSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('prices', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Product model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id) {
        return $this->render('view', [
                    'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Product model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate() {
        $model = new Product();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                        'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Product model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id) {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                        'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Product model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id) {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Product model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Product the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
        if (($model = Product::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

}
