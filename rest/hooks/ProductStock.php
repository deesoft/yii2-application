<?php

namespace rest\hooks;

use rest\models\master\ProductStock as MProductStock;
use rest\models\master\ProductUom;
use yii\base\UserException;
use rest\models\master\Cogs;
use rest\models\inventory\GoodsMovement as MGoodsMovement;

/**
 * Description of Stock
 *
 * @author MDMunir
 */
class ProductStock extends \yii\base\Behavior
{

    public function events()
    {
        return [
            'eMovementApplied' => 'movementChangeStatus',
            'eMovementRejected' => 'movementChangeStatus',
        ];
    }

    /**
     *
     * @param  array $params Required field warehouse_id, product_id, qty
     * Optional field app, reff_id, uom_id, item_value
     * @return boolean
     * @throws UserException
     */
    public function updateStock($params)
    {
        $stock = MProductStock::findOne([
                'warehouse_id' => $params['warehouse_id'],
                'product_id' => $params['product_id'],
        ]);
        if (isset($params['uom_id'])) {
            $qty_per_uom = ProductUom::find()->select('isi')
                    ->where([
                        'product_id' => $params['product_id'],
                        'uom_id' => $params['uom_id']
                    ])->scalar();
            if ($qty_per_uom === false) {
                throw new UserException("Uom '{$params['uom_id']}' not found for product '{$params['product_id']}'");
            }
        } else {
            $qty_per_uom = 1;
        }

        if (!$stock) {
            $stock = new MProductStock([
                'warehouse_id' => $params['warehouse_id'],
                'product_id' => $params['product_id'],
                'qty' => 0,
            ]);
        }
        // update cogs
        if (isset($params['price']) && $params['price'] !== '') {
            $params['qty_per_uom'] = $qty_per_uom;
            $this->updateCogs($params);
        }

        $stock->qty = $stock->qty + $params['qty'] * $qty_per_uom;
        if ($stock->canSetProperty('logParams')) {
            $logParams = ['mv_qty' => $params['qty'] * $qty_per_uom];
            foreach (['app', 'reff_id'] as $key) {
                if (isset($params[$key]) || array_key_exists($key, $params)) {
                    $logParams[$key] = $params[$key];
                }
            }
            $stock->logParams = $logParams;
        }
        if (!$stock->save()) {
            throw new UserException(implode(",\n", $stock->firstErrors));
        }

        return true;
    }

    protected function updateCogs($params)
    {
        $cogs = Cogs::findOne(['product_id' => $params['product_id']]);
        if (!$cogs) {
            $cogs = new Cogs([
                'product_id' => $params['product_id'],
                'cogs' => 0.0
            ]);
        }
        $current_stock = MProductStock::find()
            ->where(['product_id' => $params['product_id']])
            ->sum('qty');
        $qty_per_uom = $params['qty_per_uom'];
        $added_stock = $params['qty'] * $qty_per_uom;
        if ($current_stock + $added_stock != 0) {
            $cogs->cogs = 1.0 * ($cogs->cogs * $current_stock + $params['price'] * $params['qty']) / ($current_stock + $added_stock);
        } else {
            $cogs->cogs = 0;
        }
        if ($cogs->canSetProperty('logParams')) {
            $cogs->logParams = [
                'app' => $params['app'],
                'reff_id' => $params['reff_id'],
            ];
        }
        if (!$cogs->save()) {
            throw new UserException(implode(",\n", $cogs->firstErrors));
        }

        return true;
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
        $warehouse_id = $model->warehouse_id;
        $factor = $event->name == 'eMovementApplied' ? 1 : -1;
        $factor *= $model->type == MGoodsMovement::TYPE_RECEIVE ? 1 : -1;
        foreach ($model->items as $item) {
            $params = [
                'warehouse_id' => $warehouse_id,
                'product_id' => $item->product_id,
                'qty' => $factor * $item->qty,
                'uom_id' => $item->uom_id,
                'app' => 'goods_movement',
                'price' => $item->item_value,
                'reff_id' => $item->movement_id,
            ];
            $this->updateStock($params);
        }
    }
}