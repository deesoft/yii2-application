<?php

namespace app\api\controllers;

use Yii;
use app\api\base\AdvanceController;
use app\api\models\inventory\GoodsMovement as MMovement;

/**
 * Description of PurchaseController
 *
 * @property ApiPurchase $api
 * @author Misbahul D Munir <misbahuldmunir@gmail.com>
 * @since 3.0
 */
class MovementController extends AdvanceController
{
    /**
     * @inheritdoc
     */
    public $modelClass = 'app\api\models\inventory\GoodsMovement';

    /**
     * @inheritdoc
     */
    public $prefixEventName = 'eMovement';

    public $extraPatterns = [
        'GET,HEAD {id}{attribute}' => 'viewDetail',
    ];
    
    /**
     * @var array
     */
    protected $patchingStatus = [
        [MMovement::STATUS_DRAFT, MMovement::STATUS_APPLIED, 'apply'],
        [MMovement::STATUS_APPLIED, MMovement::STATUS_DRAFT, 'reject'],
    ];

    /**
     * @param \dee\base\Event $event
     */
    public function ePatch($event)
    {
        /* @var $model MMovement */
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
}