<?php

namespace rest\models\sales;

use Yii;
use rest\classes\ActiveRecord;
use rest\models\master\Uom;
use rest\models\master\Product;

/**
 * This is the model class for table "{{%sales_dtl}}".
 *
 * @property integer $sales_id
 * @property integer $product_id
 * @property integer $uom_id
 * @property double $qty
 * @property double $price
 * @property double $total_release
 * @property double $cogs
 * @property double $discount
 * @property double $tax
 *
 * @property Sales $sales
 * @property Product $product
 * @property Uom $uom Uom transaction
 * 
 * @author Misbahul D Munir <misbahuldmunir@gmail.com>  
 * @since 3.0
 */
class SalesDtl extends ActiveRecord
{

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%sales_dtl}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['product_id', 'uom_id', 'qty', 'price', 'cogs'], 'required'],
            [['sales_id', 'product_id', 'uom_id'], 'integer'],
            [['qty', 'price', 'cogs', 'discount', 'tax'], 'number'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'sales_id' => 'Sales ID',
            'product_id' => 'Product ID',
            'uom_id' => 'Uom ID',
            'qty' => 'Qty',
            'price' => 'Price',
            'total_release' => 'Qty Release',
            'cogs' => 'Cogs',
            'discount' => 'Discount',
            'tax' => 'Tax',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSales()
    {
        return $this->hasOne(Sales::className(), ['id' => 'sales_id']);
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