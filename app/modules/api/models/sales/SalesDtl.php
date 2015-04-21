<?php

namespace app\api\models\sales;

use yii\helpers\ArrayHelper;
use app\api\models\master\Uom;
use app\api\models\master\Product;
use app\api\models\master\ProductUom;

/**
 * SalesDtl
 *
 * @property Product $product
 * @property ProductUom[] $productUoms
 * @property Uom[] $uoms
 * @property array $uomList
 * @property Sales $sales
 * 
 * @author Misbahul D Munir <misbahuldmunir@gmail.com>
 * @since 1.0
 */
class SalesDtl extends \biz\api\models\sales\SalesDtl
{
    private $_uomList;

    public function rules()
    {
        return array_merge([
            [['cogs'],'default','value'=>0]
        ], parent::rules());
    }
    public function getUomList()
    {
        if ($this->_uomList === null) {
            $this->_uomList = ArrayHelper::map($this->uoms, 'id', 'name');
        }
        return $this->_uomList;
    }

    public function getProduct()
    {
        return $this->hasOne(Product::className(), ['id' => 'product_id']);
    }

    public function getProductUoms()
    {
        return $this->hasMany(ProductUom::className(), ['product_id' => 'id'])->via('product');
    }

    public function getUoms()
    {
        return $this->hasMany(Uom::className(), ['id' => 'uom_id'])->via('productUoms');
    }

    public function getSales()
    {
        return $this->hasOne(Sales::className(), ['id' => 'sales_id']);
    }
    
    public function getUom()
    {
        return $this->hasOne(Uom::className(), ['id' => 'uom_id']);
    }
}