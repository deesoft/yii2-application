<?php

namespace app\controllers\purchase;

use Yii;
use app\models\purchase\Purchase;
use dee\angular\Controller;
use yii\web\NotFoundHttpException;
use dee\angular\tools\DataSource;

/**
 * PurchaseController implements the CRUD actions for Purchase model.
 */
class PurchaseController extends Controller
{

    protected function verbs()
    {
        return[
            'delete' => ['post'],
        ];
    }

    /**
     * Lists all Purchase models.
     * @return mixed
     */
    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionList()
    {
        $dataSource = new DataSource([
            'query' => Purchase::find(),
        ]);
        return $dataSource->search(Yii::$app->request->getQueryParams());
    }

    /**
     * Displays a single Purchase model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->findModel($id);
    }

    /**
     * Creates a new Purchase model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Purchase([
            'branch_id' => 1
        ]);
        $transaction = Yii::$app->db->beginTransaction();
        try {
            $model->load(Yii::$app->request->post(),'');
            $model->purchaseDtls = Yii::$app->request->post('details', []);
            if ($model->save()) {
                $transaction->commit();
            } else {
                $transaction->rollBack();
            }
        } catch (\Exception $e) {
            $transaction->rollBack();
            $model->addError('', $e->getMessage());
        }

        return $model;
    }

    /**
     * Updates an existing Purchase model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        $transaction = Yii::$app->db->beginTransaction();
        try {
            $model->load(Yii::$app->request->post(),'');
            if (($details = Yii::$app->request->post('details')) !== null) {
                $model->purchaseDtls = $details;
            }
            if ($model->save()) {
                $transaction->commit();
            } else {
                $transaction->rollBack();
            }
        } catch (\Exception $e) {
            $transaction->rollBack();
            $model->addError('', $e->getMessage());
        }

        return $model;
    }

    public function actionReceive($id)
    {
        return $this->redirect(['/inventory/movement/create', 'type' => 100, 'id' => $id]);
    }

    /**
     * Deletes an existing Purchase model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        return $model->delete();
    }

    /**
     * Finds the Purchase model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Purchase the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Purchase::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}