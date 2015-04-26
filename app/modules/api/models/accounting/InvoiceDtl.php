<?php

namespace app\api\models\accounting;

use Yii;

/**
 * This is the model class for table "{{%invoice_dtl}}".
 *
 * @property integer $invoice_id
 * @property integer $reff_type
 * @property integer $reff_id
 * @property string $description
 * @property double $value
 *
 * @property Invoice $invoice
 * 
 * @author Misbahul D Munir <misbahuldmunir@gmail.com>  
 * @since 3.0
 */
class InvoiceDtl extends \app\api\base\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%invoice_dtl}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['value'], 'required'],
            [['invoice_id', 'reff_type', 'reff_id'], 'integer'],
            [['value'], 'number'],
            [['description'], 'string', 'max' => 64]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'invoice_id' => 'Invoice ID',
            'reff_type' => 'Reff Type',
            'reff_id' => 'Reff ID',
            'description' => 'Description',
            'value' => 'Value',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getInvoice()
    {
        return $this->hasOne(Invoice::className(), ['id' => 'invoice_id']);
    }
}
