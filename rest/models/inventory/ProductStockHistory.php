<?php

namespace rest\models\inventory;

use Yii;

/**
 * This is the model class for table "{{%product_stock_history}}".
 *
 * @property string $time
 * @property integer $warehouse_id
 * @property integer $product_id
 * @property double $qty
 * 
 * @author Misbahul D Munir <misbahuldmunir@gmail.com>  
 * @since 3.0
 */
class ProductStockHistory extends \rest\classes\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%product_stock_history}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['time', 'warehouse_id', 'product_id', 'qty'], 'required'],
            [['time'], 'safe'],
            [['warehouse_id', 'product_id'], 'integer'],
            [['qty'], 'number']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'time' => 'Time',
            'warehouse_id' => 'Warehouse ID',
            'product_id' => 'Product ID',
            'qty' => 'Qty',
        ];
    }
}
