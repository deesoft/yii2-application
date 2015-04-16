<?php

namespace app\controllers\inventory;

use Yii;
use app\models\inventory\GoodsMovement;
use app\models\inventory\searchs\GoodsMovement as GoodsMovementSearch;
use dee\angular\Controller;
use yii\web\NotFoundHttpException;
use yii\helpers\ArrayHelper;
use app\models\inventory\GoodsMovementDtl;
use biz\core\base\Configs;
use yii\data\ActiveDataProvider;

/**
 * MovementController implements the CRUD actions for GoodsMovement model.
 */
class MovementController extends Controller
{

    public function actions()
    {
        $action = parent::actions();

        return ArrayHelper::merge($action, [
                'resource' => [
                    'extraPatrens' => [
                        'POST {type}{reff}' => 'create',
                    ]
                ],
        ]);
    }

    /**
     * Lists all GoodsMovement models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new GoodsMovementSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
        ]);
    }

    public function query()
    {
        $dataProvider = new ActiveDataProvider([
            'query'=>  GoodsMovement::find()
        ]);
        
        return $dataProvider;
    }

    /**
     * Displays a single GoodsMovement model.
     * @param integer $id
     * @return mixed
     */
    public function view($id)
    {
        return $this->findModel($id);
    }

    /**
     * Creates a new GoodsMovement model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function create($type = null, $reff = null)
    {
        if ($type !== null) {
            $model = GoodsMovement::findOne([
                    'reff_type' => $type,
                    'reff_id' => $reff,
                    'status' => GoodsMovement::STATUS_DRAFT,
            ]);
        }
        if (!isset($model)) {
            $model = new GoodsMovement([
                'reff_type' => $type,
                'reff_id' => $reff,
            ]);
        }

        $transaction = Yii::$app->db->beginTransaction();
        try {
            $model->load(Yii::$app->request->post(), '');
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
     * Updates an existing GoodsMovement model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function update($id)
    {
        $model = $this->findModel($id);
        $transaction = Yii::$app->db->beginTransaction();
        try {
            $model->load(Yii::$app->request->post(), '');
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

    protected function getReference($reff_type, $reff_id, $origin = [])
    {
        $config = Configs::movement($reff_type);
        ;
        $class = $config['class'];
        $relation = $config['relation'];

        $modelRef = $class::findOne($reff_id);
        $refDtls = $modelRef->$relation;

        $details = ArrayHelper::index($origin, 'product_id');
        foreach ($refDtls as $refDtl) {
            if (!isset($details[$refDtl->product_id])) {
                $details[$refDtl->product_id] = new GoodsMovementDtl([
                    'product_id' => $refDtl->product_id,
                ]);
            }
            if (!empty($config['apply_method'])) {
                call_user_func([$refDtl, $config['apply_method']], $details[$refDtl->product_id]);
            }
        }
        return [$modelRef, array_values($details)];
    }

    /**
     * Deletes an existing GoodsMovement model.
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

    public function apply($id)
    {
        $model = $this->findModel($id);
        $transaction = Yii::$app->db->beginTransaction();
        try {
            $model->load(Yii::$app->request->post(), '');
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
     * Finds the GoodsMovement model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return GoodsMovement the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = GoodsMovement::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
