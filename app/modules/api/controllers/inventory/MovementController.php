<?php

namespace app\api\controllers\inventory;

use Yii;
use app\api\base\Controller;
use app\api\models\inventory\GoodsMovement as MGoodsMovement;

/**
 * Description of MovementController
 *
 * @property ApiPurchase $api
 * @author Misbahul D Munir <misbahuldmunir@gmail.com>
 * @since 3.0
 */
class MovementController extends Controller
{
    /**
     * @inheritdoc
     */
    public $modelClass = 'app\api\models\inventory\GoodsMovement';

    /**
     * @inheritdoc
     */
    public $prefixEventName = 'eMovement';

    /**
     * @var array
     */
    protected $patchingStatus = [
        [MGoodsMovement::STATUS_DRAFT, MGoodsMovement::STATUS_PROCESS, 'process'],
        [MGoodsMovement::STATUS_PROCESS, MGoodsMovement::STATUS_DRAFT, 'reject'],
    ];

    /**
     *
     * @var array
     */
    protected $reffMap = [
        'purchase' => 100,
    ];

    /**
     *
     * @var array
     */
    protected $types = [
        100 => MGoodsMovement::TYPE_RECEIVE,
    ];

    /**
     * @inheritdoc
     */
    public function events()
    {
        return[
            'patch' => 'ePatch',
            'query' => 'eQuery',
            'create' => 'eCreate'
        ];
    }

    /**
     * @param \dee\base\Event $event
     */
    public function ePatch($event)
    {
        /* @var $model MGoodsMovement */
        $model = $event->params[0];
        $dirty = $model->getDirtyAttributes();
        $olds = $model->getOldAttributes();
        // status changed
        if (isset($dirty['status'])) {
            foreach ($this->patchingStatus as $change) {
                if ($olds['status'] == $change[0] && $dirty['status'] == $change[1]) {
                    $this->fire($change[2], [$model]);
                }
            }
        }
    }

    /**
     * @param \dee\base\Event $event
     */
    public function eQuery($event)
    {
        /* @var $provider \yii\data\ActiveDataProvider */
        $provider = $event->params[0];
        $params = Yii::$app->request->getQueryParams();
        if (isset($params['reff']) && isset($this->reffMap[$params['reff']])) {
            $params['reff_type'] = $this->reffMap[$params['reff']];
        }
        $query = $provider->query;
        $fields = [
            'id', 'type', 'reff_type', 'reff_id', 'status',
            'created_by', 'updated_by', 'warehouse_id',
            'number', 'date', 'description', 'created_at', 'updated_at',
        ];
        $filters = [];
        foreach ($fields as $field) {
            if (isset($params[$field])) {
                $filters[$field] = $params[$field];
            }
        }
        $query->andFilterWhere($filters);
    }

    /**
     * @param \dee\base\Event $event
     */
    public function eCreate($event)
    {
        /* @var $model MGoodsMovement */
        $model = $event->params[0];
        $params = Yii::$app->request->getQueryParams();
        if (isset($params['reff']) && isset($this->reffMap[$params['reff']])) {
            $model->reff_type = $this->reffMap[$params['reff']];
        }
        if (isset($this->types[$model->reff_type]) && empty($model->type)) {
            $model->type = $this->types[$model->reff_type];
        }
    }
}