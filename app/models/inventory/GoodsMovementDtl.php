<?php

namespace app\models\inventory;

use Yii;
use app\models\master\Product;
use app\models\master\Uom;

/**
 * GoodsMovementDtl
 *
 * @property Product $product
 * @property Uom $uom
 * 
 * @author Misbahul D Munir <misbahuldmunir@gmail.com>
 * @since 1.0
 */
class GoodsMovementDtl extends \biz\core\models\inventory\GoodsMovementDtl
{

    public function getProduct()
    {
        return $this->hasOne(Product::className(), ['id' => 'product_id']);
    }
    
    public function getUom()
    {
        return $this->hasOne(Uom::className(), ['id' => 'uom_id']);
    }
}