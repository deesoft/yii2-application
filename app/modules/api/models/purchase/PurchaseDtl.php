<?php

namespace app\api\models\purchase;

use app\api\base\ActiveRecord;
use yii\helpers\ArrayHelper;
use app\api\models\master\Uom;
use app\api\models\master\Product;
use app\api\models\master\ProductUom;

/**
 * PurchaseDtl
 *
 * This is the model class for table "{{%purchase_dtl}}".
 *
 * @property integer $purchase_id
 * @property integer $product_id
 * @property integer $uom_id
 * @property double $qty
 * @property double $price
 * @property double $discount
 * @property double $total_receive
 *
 * @property Purchase $purchase
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
class PurchaseDtl extends ActiveRecord
{

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%purchase_dtl}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['product_id', 'uom_id', 'qty', 'price'], 'required'],
            [['purchase_id', 'product_id', 'uom_id'], 'integer'],
            [['qty', 'price'], 'number'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'purchase_id' => 'Purchase ID',
            'product_id' => 'Product ID',
            'uom_id' => 'Uom ID',
            'qty' => 'Qty',
            'price' => 'Price',
            'discount' => 'Discount',
            'total_receive' => 'Qty Receive',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPurchase()
    {
        return $this->hasOne(Purchase::className(), ['id' => 'purchase_id']);
    }
    private $_uomList;

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

    public function getUom()
    {
        return $this->hasOne(Uom::className(), ['id' => 'uom_id']);
    }

    public function extraFields()
    {
        return[
            'product',
            'uom'
        ];
    }
}