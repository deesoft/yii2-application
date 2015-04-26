<?php

namespace app\api\models\inventory;

use Yii;

/**
 * This is the model class for table "{{%goods_movement_dtl}}".
 *
 * @property integer $movement_id
 * @property integer $product_id
 * @property integer $uom_id
 * @property double $qty
 * @property double $item_value cogs value
 * @property double $trans_value invoice value
 *
 * @property GoodsMovement $movement
 * 
 * @author Misbahul D Munir <misbahuldmunir@gmail.com>  
 * @since 3.0
 */
class GoodsMovementDtl extends \app\api\base\ActiveRecord
{
    /**
     * @var double 
     */
    public $avaliable;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%goods_movement_dtl}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['product_id', 'uom_id', 'qty'], 'required',],
            [['movement_id', 'product_id', 'uom_id'], 'integer'],
            [['qty', 'item_value', 'trans_value', 'avaliable'], 'number'],
            [['qty'], 'compare', 'compareAttribute' => 'avaliable', 'operator' => '<=',
                'when' => function($obj) {
                return $obj->avaliable !== null && $obj->avaliable !== '';
            }],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'movement_id' => 'Movement ID',
            'product_id' => 'Product ID',
            'qty' => 'Qty',
            'item_value' => 'Item Value',
            'trans_value' => 'Trans Value',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMovement()
    {
        return $this->hasOne(GoodsMovement::className(), ['id' => 'movement_id']);
    }
}