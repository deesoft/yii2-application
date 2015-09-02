<?php

namespace rest\models\inventory;

use Yii;

/**
 * This is the model class for table "{{%stock_adjustment_dtl}}".
 *
 * @property integer $adjustment_id
 * @property integer $product_id
 * @property integer $uom_id
 * @property double $qty
 * @property double $item_value
 *
 * @property StockAdjustment $adjustment
 * 
 * @author Misbahul D Munir <misbahuldmunir@gmail.com>  
 * @since 3.0
 */
class StockAdjustmentDtl extends \rest\classes\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%stock_adjustment_dtl}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['adjustment_id', 'product_id', 'uom_id', 'qty', 'item_value'], 'required'],
            [['adjustment_id', 'product_id', 'uom_id'], 'integer'],
            [['qty', 'item_value'], 'number']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'adjustment_id' => 'Adjustment ID',
            'product_id' => 'Product ID',
            'uom_id' => 'Uom ID',
            'qty' => 'Qty',
            'item_value' => 'Item Value',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAdjustment()
    {
        return $this->hasOne(StockAdjustment::className(), ['id' => 'adjustment_id']);
    }
}
