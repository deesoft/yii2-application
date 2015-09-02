<?php

namespace rest\models\inventory;

use Yii;

/**
 * This is the model class for table "{{%stock_opname_dtl}}".
 *
 * @property integer $opname_id
 * @property integer $product_id
 * @property integer $uom_id
 * @property double $qty
 *
 * @property StockOpname $opname
 * 
 * @author Misbahul D Munir <misbahuldmunir@gmail.com>  
 * @since 3.0
 */
class StockOpnameDtl extends \rest\classes\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%stock_opname_dtl}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['opname_id', 'product_id', 'uom_id', 'qty'], 'required'],
            [['opname_id', 'product_id', 'uom_id'], 'integer'],
            [['qty'], 'number']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'opname_id' => 'Opname ID',
            'product_id' => 'Product ID',
            'uom_id' => 'Uom ID',
            'qty' => 'Qty',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOpname()
    {
        return $this->hasOne(StockOpname::className(), ['id' => 'opname_id']);
    }
}
