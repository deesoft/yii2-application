<?php

namespace app\api\hooks\sales;

use Yii;
use app\api\models\inventory\GoodsMovement as MGoodsMovement;
use app\api\models\sales\Sales as MSales;
use yii\helpers\ArrayHelper;

/**
 * Sales
 *
 * @author Misbahul D Munir <misbahuldmunir@gmail.com>
 * @since 3.0
 */
class Sales extends \yii\base\Behavior
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
     * @param \app\api\base\Event $event
     */
    public function goodsMovementApplied($event)
    {
        /* @var $model MGoodsMovement */
        $model = $event->params[0];
        /*
         * 200 = Sales
         */
        if (!in_array($model->reff_type, [200])) {
            return;
        }

        $sales = MSales::findOne($model->reff_id);
        $salesDtls = ArrayHelper::index($sales->salesDtls, 'product_id');
        // change total qty for reff document
        /* @var $purcDtl \app\api\models\sales\SalesDtl */
        foreach ($model->goodsMovementDtls as $detail) {
            $salesDtl = $salesDtls[$detail->product_id];
            $salesDtl->total_release += $detail->qty;
            $salesDtl->save(false);
        }
        $complete = true;
        foreach ($salesDtls as $salesDtl) {
            if ($salesDtl->total_release != $salesDtl->qty) {
                $complete = false;
                break;
            }
        }
        if ($complete) {
            $sales->status = MSales::STATUS_COMPLETE_RELEASE;
            $sales->save(false);
        }  elseif($sales->status == MSales::STATUS_DRAFT) {
            $sales->status = MSales::STATUS_PARTIAL_RELEASE;
            $sales->save(false);
        }
    }
}