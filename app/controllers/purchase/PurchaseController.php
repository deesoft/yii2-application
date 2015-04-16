<?php

namespace app\controllers\purchase;

use Yii;
use app\models\purchase\Purchase;
use dee\angular\Controller;
use yii\web\NotFoundHttpException;
use yii\data\ActiveDataProvider;

/**
 * PurchaseController implements the CRUD actions for Purchase model.
 */
class PurchaseController extends Controller
{
    public $enableCsrfValidation = true;

    /**
     * Lists all Purchase models.
     * @return mixed
     */
    public function actionIndex()
    {
        return $this->render('index');
    }

    public function query()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => Purchase::find(),
        ]);
        return $dataProvider;
    }

    /**
     * Displays a single Purchase model.
     * @param integer $id
     * @return mixed
     */
    public function view($id)
    {
        return $this->findModel($id);
    }

    /**
     * Creates a new Purchase model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function create()
    {
        $model = new Purchase([
            'branch_id' => 1
        ]);
        $transaction = Yii::$app->db->beginTransaction();
        try {
            $model->load(Yii::$app->request->post(),'');
            if ($model->save()) {
                $model->refresh();
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
    public function update($id)
    {
        $model = $this->findModel($id);

        $transaction = Yii::$app->db->beginTransaction();
        try {
            $model->load(Yii::$app->request->post(),'');
            if ($model->save()) {
                $model->refresh();
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
     * Deletes an existing Purchase model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function delete($id)
    {
        $model = $this->findModel($id);
        $transaction = Yii::$app->db->beginTransaction();
        try {
            if ($model->delete()) {
                $transaction->commit();
            } else {
                $transaction->rollBack();
                return false;
            }
        } catch (\Exception $e) {
            $transaction->rollBack();
            throw $e;
        }

        return true;
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
