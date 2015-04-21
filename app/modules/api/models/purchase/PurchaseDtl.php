<?php

namespace app\api\models\purchase;

use yii\helpers\ArrayHelper;
use app\api\models\master\Uom;
use app\api\models\master\Product;
use app\api\models\master\ProductUom;

/**
 * PurchaseDtl
 *
 * @property Product $product
 * @property ProductUom[] $productUoms
 * @property ProductUom $productUom
 * @property Uom[] $uoms Uom of product
 * @property Purchase $purchase
 * @property array $uomList
 * @property Uom $uom Uom transaction
 * 
 * @author Misbahul D Munir <misbahuldmunir@gmail.com>
 * @since 1.0
 */
class PurchaseDtl extends \biz\api\models\purchase\PurchaseDtl
{
    private $_uomList;

    public function getUomList()
    {
        if ($this->_uomList === null) {
            $this->_uomList = ArrayHelper::map($this->uoms, 'id', 'name');
        }
        return $this->_uomList;
    }

    public function getUoms()
    {
        return $this->hasMany(Uom::className(), ['id' => 'uom_id'])->via('productUoms');
    }

    public function getProduct()
    {
        return $this->hasOne(Product::className(), ['id' => 'product_id']);
    }

    public function getProductUoms()
    {
        return $this->hasMany(ProductUom::className(), ['product_id' => 'product_id']);
    }

    public function getProductUom()
    {
        return $this->hasOne(ProductUom::className(), ['product_id' => 'product_id', 'uom_id' => 'uom_id']);
    }

    public function getPurchase()
    {
        return $this->hasOne(Purchase::className(), ['id' => 'purchase_id']);
    }

    public function getUom()
    {
        return $this->hasOne(Uom::className(), ['id' => 'uom_id']);
    }
}