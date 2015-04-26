<?php

namespace app\api\models\sales;

use Yii;

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
 * 
 * @author Misbahul D Munir <misbahuldmunir@gmail.com>  
 * @since 3.0
 */
class SalesDtl extends \app\api\base\ActiveRecord
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
     * Set default value for GI detail
     * @param \app\api\models\inventory\GoodsMovementDtl $model
     */
    public function applyGI($model)
    {
        $model->avaliable = $this->qty - $this->total_release;
        $model->item_value = $this->cogs;
        $model->trans_value = $this->price;
        $model->uom_id = $this->uom_id;
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
}