<?php

namespace rest\hooks;

use Yii;
use yii\base\Behavior;
use rest\models\inventory\GoodsMovement as MGoodsMovement;
use rest\models\inventory\Transfer as MTransfer;
use yii\helpers\ArrayHelper;

/**
 * Transfer
 *
 * @author Misbahul D Munir <misbahuldmunir@gmail.com>
 * @since 3.0
 */
class Transfer extends Behavior
{

    public function events()
    {
        return [
            'e_good-movement_applied' => 'goodsMovementApplied',
        ];
    }

    /**
     * Handler for Good Movement created.
     * It used to update stock
     * @param \dee\base\Event $event
     */
    public function goodsMovementApplied($event)
    {
        /* @var $model MGoodsMovement */
        $model = $event->params[0];
        /*
         * 300 = Transfer Release
         * 400 = Transfer Receive
         */
        if (!in_array($model->reff_type, [300,400])) {
            return;
        }
        $type = $model->type;
        $transfer = MTransfer::findOne($model->reff_id);
        $transferDtls = ArrayHelper::index($transfer->transferDtls, 'product_id');
        // change total qty for reff document
        /* @var $transferDtl \rest\models\inventory\TransferDtl */
        foreach ($model->goodsMovementDtls as $detail) {
            $transferDtl = $transferDtls[$detail->product_id];
            if($type == MGoodsMovement::TYPE_ISSUE){
                $transferDtl->total_release += $detail->qty;
            }  else {
                $transferDtl->total_receive += $detail->qty;
            }
            $transferDtl->save(false);
        }
        $complete = true;
        foreach ($transferDtls as $transferDtl) {
            if ($transferDtl->total_release != $transferDtl->qty) {
                $complete = false;
                break;
            }
        }
        if ($complete) {
            $transfer->status = MTransfer::STATUS_COMPLETE_RELEASE;
            $transfer->save(false);
        }  elseif($transfer->status == MTransfer::STATUS_DRAFT) {
            $transfer->status = MTransfer::STATUS_PARTIAL_RELEASE;
            $transfer->save(false);
        }
    }
}