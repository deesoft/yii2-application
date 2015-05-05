<?php

namespace app\api\hooks\purchase;

use Yii;
use app\api\models\inventory\GoodsMovement as MGoodsMovement;
use app\api\models\purchase\Purchase as MPurchase;
use yii\helpers\ArrayHelper;

/**
 * Purchase
 *
 * @author Misbahul D Munir <misbahuldmunir@gmail.com>
 * @since 3.0
 */
class Purchase extends \yii\base\Behavior
{
    public $types = [100,];

    /**
     * @inheritdoc
     */
    public function events()
    {
        return [
            'eMovementCreate' => 'movementCreate',
            'eMovementUpdate' => 'movementUpdate',
            'eMovementApply' => 'movementChangeStatus',
            'eMovementReject' => 'movementChangeStatus',
        ];
    }

    /**
     * Handler for Good Movement created.
     * It used to update stock
     * @param \dee\base\Event $event
     */
    public function movementChangeStatus($event)
    {
        /* @var $model MGoodsMovement */
        $model = $event->params[0];
        if (!in_array($model->reff_type, $this->types)) {
            return;
        }
        $factor = $event->name == 'eMovementApply' ? 1 : -1;

        $purchase = MPurchase::findOne($model->reff_id);
        $purchaseItems = ArrayHelper::index($purchase->items, 'product_id');
        // change total qty for reff document
        /* @var $purcDtl \app\api\models\purchase\PurchaseDtl */
        foreach ($model->items as $detail) {
            $purcDtl = $purchaseItems[$detail->product_id];
            $purcDtl->total_receive += $factor * $detail->qty;
            $purcDtl->save(false);
        }
    }

    /**
     * Handler for Good Movement created.
     * It used to update stock
     * @param \dee\base\Event $event
     */
    public function movementCreate($event)
    {
        /* @var $model MGoodsMovement */
        $model = $event->params[0];
        if (!in_array($model->reff_type, $this->types)) {
            return;
        }

        $purchase = MPurchase::findOne($model->reff_id);
        $this->applyAvaliableMovement($model, $purchase);
    }

    /**
     * Handler for Good Movement Update.
     * It used to update stock
     * @param \dee\base\Event $event
     */
    public function movementUpdate($event)
    {
        /* @var $model MGoodsMovement */
        $model = $event->params[0];
        if (!in_array($model->reff_type, $this->types)) {
            return;
        }

        $purchase = MPurchase::findOne($model->reff_id);
        $this->applyAvaliableMovement($model, $purchase);
    }

    protected function applyAvaliableMovement($model, $purchase)
    {
        $purchaseItems = ArrayHelper::index($purchase->items, 'product_id');
        // change total qty for reff document
        /* @var $purcDtl \app\api\models\purchase\PurchaseDtl */
        foreach ($model->items as $detail) {
            $purcDtl = $purchaseItems[$detail->product_id];
            $detail->avaliable = $purcDtl->qty - $purcDtl->total_receive;
        }
    }
}