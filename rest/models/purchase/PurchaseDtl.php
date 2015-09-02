<?php

namespace rest\models\purchase;

use rest\classes\ActiveRecord;
use rest\models\master\Uom;
use rest\models\master\Product;

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
 * @property double $avaliable
 *
 * @property Purchase $purchase
 * @property Product $product
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
            'uom',
        ];
    }
}