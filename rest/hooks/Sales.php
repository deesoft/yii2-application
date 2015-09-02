<?php

namespace rest\hooks;

use Yii;
use yii\base\Behavior;
use rest\models\inventory\GoodsMovement as MGoodsMovement;
use rest\models\sales\Sales as MSales;
use yii\helpers\ArrayHelper;

/**
 * Sales
 *
 * @author Misbahul D Munir <misbahuldmunir@gmail.com>
 * @since 3.0
 */
class Sales extends Behavior
{
    public $types = [200,];

    /**
     * @inheritdoc
     */
    public function events()
    {
        return [
            'eMovementApply' => 'movementApply',
            'eMovementReject' => 'movementReject',
            'eMovementApplied' => 'movementApplied',
            'eMovementRejected' => 'movementRejected',
        ];
    }

    /**
     * Handler for Good Movement created.
     * It used to update stock
     * @param \dee\base\Event $event
     */
    public function movementApply($event)
    {
        /* @var $model MGoodsMovement */
        $model = $event->params[0];
        if (!in_array($model->reff_type, $this->types)) {
            return;
        }

        $sales = MSales::findOne($model->reff_id);
        $salesItems = ArrayHelper::index($sales->items, 'product_id');
        // change total qty for reff document
        /* @var $salesDtl \rest\models\sales\SalesDtl */
        foreach ($model->items as $detail) {
            $salesDtl = $salesItems[$detail->product_id];
            // set qty avaliable for GR
            $detail->avaliable = $salesDtl->qty - $salesDtl->total_release;
        }
    }

    /**
     * Handler for Good Movement created.
     * It used to update stock
     * @param \dee\base\Event $event
     */
    public function movementApplied($event)
    {
        /* @var $model MGoodsMovement */
        $model = $event->params[0];
        if (!in_array($model->reff_type, $this->types)) {
            return;
        }

        $sales = MSales::findOne($model->reff_id);
        $salesItems = ArrayHelper::index($sales->items, 'product_id');
        // change total qty for reff document
        /* @var $salesDtl \rest\models\sales\SalesDtl */
        foreach ($model->items as $detail) {
            $salesDtl = $salesItems[$detail->product_id];

            $salesDtl->total_release += $detail->qty;
            $salesDtl->save(false);
        }
    }

    /**
     * Handler for Good Movement created.
     * It used to update stock
     * @param \dee\base\Event $event
     */
    public function movementReject($event)
    {
        /* @var $model MGoodsMovement */
        $model = $event->params[0];
        if (!in_array($model->reff_type, $this->types)) {
            return;
        }

        //$sales = MSales::findOne($model->reff_id);
    }

    /**
     * Handler for Good Movement created.
     * It used to update stock
     * @param \dee\base\Event $event
     */
    public function movementRejected($event)
    {
        /* @var $model MGoodsMovement */
        $model = $event->params[0];
        if (!in_array($model->reff_type, $this->types)) {
            return;
        }

        $sales = MSales::findOne($model->reff_id);
        $salesItems = ArrayHelper::index($sales->items, 'product_id');
        // change total qty for reff document
        /* @var $salesDtl \rest\models\sales\SalesDtl */
        foreach ($model->items as $detail) {
            $salesDtl = $salesItems[$detail->product_id];

            $salesDtl->total_release -= $detail->qty;
            $salesDtl->save(false);
        }
    }
}