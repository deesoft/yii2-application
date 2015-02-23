<?php

namespace app\controllers\inventory;

use Yii;
use app\models\inventory\GoodsMovement;
use app\models\inventory\searchs\GoodsMovement as GoodsMovementSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use biz\core\components\inventory\GoodsMovement as ApiMovement;
use yii\helpers\ArrayHelper;
use app\models\inventory\GoodsMovementDtl;
use biz\core\base\Configs;

/**
 * MovementController implements the CRUD actions for GoodsMovement model.
 */
class MovementController extends Controller
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

    /**
     * Displays a single GoodsMovement model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
                'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new GoodsMovement model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($type, $id)
    {
        $model = GoodsMovement::findOne([
                'reff_type' => $type,
                'reff_id' => $id,
                'status' => GoodsMovement::STATUS_DRAFT,
        ]);
        $model = $model ? : new GoodsMovement([
            'reff_type' => $type,
            'reff_id' => $id,
        ]);
        $api = new ApiMovement();
        $config = Configs::movement($type);

        list($modelRef, $details) = $this->getReference($type, $id, $model->goodsMovementDtls);
        $model->populateRelation('goodsMovementDtls', $details);
        if ($model->load(Yii::$app->request->post())) {
            try {
                $transaction = Yii::$app->db->beginTransaction();
                $data = $model->attributes;

                $data['details'] = Yii::$app->request->post('GoodsMovementDtl', []);

                $model = $api->create($data, $model);
                if (!$model->hasErrors() && !$model->hasRelatedErrors()) {
                    $transaction->commit();
                    return $this->redirect(['view', 'id' => $model->id]);
                } else {
                    $transaction->rollBack();
                }
            } catch (\Exception $exc) {
                $transaction->rollBack();
                throw $exc;
            }
        }
        return $this->render('create', [
                'model' => $model,
                'modelRef' => $modelRef,
                'details' => $model->goodsMovementDtls,
                'config' => $config,
        ]);
    }

    /**
     * Updates an existing GoodsMovement model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $api = new ApiMovement();

        list($modelRef, $details) = $this->getReference($model->reff_type, $model->reff_id, $model->goodsMovementDtls);
        $config = Configs::movement($model->reff_type);
        $model->populateRelation('goodsMovementDtls', $details);
        if ($model->load(Yii::$app->request->post())) {
            try {
                $transaction = Yii::$app->db->beginTransaction();
                $data = $model->attributes;

                $data['details'] = Yii::$app->request->post('GoodsMovementDtl', []);

                $model = $api->update($id, $data, $model);
                if (!$model->hasErrors() && !$model->hasRelatedErrors()) {
                    $transaction->commit();
                    return $this->redirect(['view', 'id' => $model->id]);
                } else {
                    $transaction->rollBack();
                }
            } catch (\Exception $exc) {
                $transaction->rollBack();
                throw $exc;
            }
        }
        return $this->render('update', [
                'model' => $model,
                'modelRef' => $modelRef,
                'details' => $model->goodsMovementDtls,
                'config' => $config,
        ]);
    }

    protected function getReference($reff_type, $reff_id, $origin = [])
    {
        $config = Configs::movement($reff_type);;
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
    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        try {
            $transaction = Yii::$app->db->beginTransaction();
            $api = new ApiMovement();
            if ($api->delete($id, $model)) {
                $transaction->commit();
                return $this->redirect(['index']);
            } else {
                $transaction->rollBack();
            }
        } catch (\Exception $exc) {
            $transaction->rollBack();
            throw $exc;
        }
    }

    public function actionApply($id)
    {
        $model = $this->findModel($id);
        try {
            $transaction = Yii::$app->db->beginTransaction();
            $api = new ApiMovement();
            if ($api->apply($id, $model)) {
                $transaction->commit();
                return $this->redirect(['index']);
            } else {
                $transaction->rollBack();
            }
        } catch (\Exception $exc) {
            $transaction->rollBack();
            throw $exc;
        }
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