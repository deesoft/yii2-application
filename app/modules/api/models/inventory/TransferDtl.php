<?php

namespace app\api\models\inventory;

use Yii;

/**
 * This is the model class for table "{{%transfer_dtl}}".
 *
 * @property integer $transfer_id
 * @property integer $product_id
 * @property integer $uom_id
 * @property double $qty
 * @property double $total_release
 * @property double $total_receive
 *
 * @property Transfer $transfer
 * 
 * @author Misbahul D Munir <misbahuldmunir@gmail.com>  
 * @since 3.0
 */
class TransferDtl extends \app\api\base\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%transfer_dtl}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['product_id', 'uom_id'], 'required'],
            [['transfer_id', 'product_id', 'uom_id'], 'integer'],
            [['qty', 'total_release', 'total_receive'], 'number']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'transfer_id' => 'Transfer ID',
            'product_id' => 'Product ID',
            'uom_id' => 'Uom ID',
            'qty' => 'Qty',
            'total_release' => 'Total Release',
            'total_receive' => 'Total Receive',
        ];
    }


    /**
     * Set default value for GR detail
     * @param \app\api\models\inventory\GoodsMovementDtl $model
     */
    public function applyGI($model)
    {
        $model->avaliable = $this->qty - $this->total_release;
        $model->uom_id = $this->uom_id;
    }

    /**
     * Set default value for GR detail
     * @param \app\api\models\inventory\GoodsMovementDtl $model
     */
    public function applyGR($model)
    {
        $model->avaliable = $this->total_release - $this->total_receive;
        $model->uom_id = $this->uom_id;
    }
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTransfer()
    {
        return $this->hasOne(Transfer::className(), ['id' => 'transfer_id']);
    }
}
