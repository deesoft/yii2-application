<?php

namespace app\api\models\accounting;

use Yii;
use app\api\base\Configs;

/**
 * This is the model class for table "{{%invoice}}".
 *
 * @property integer $id
 * @property string $number
 * @property string $date
 * @property string $due_date
 * @property integer $type
 * @property integer $vendor_id
 * @property integer $reff_type
 * @property integer $reff_id
 * @property double $value
 * @property integer $status
 * @property string $created_at
 * @property integer $created_by
 * @property string $updated_at
 * @property integer $updated_by
 *
 * @property PaymentDtl[] $paymentDtls
 * @property Payment[] $payments
 * @property InvoiceDtl[] $invoiceDtls
 * 
 * @author Misbahul D Munir <misbahuldmunir@gmail.com>  
 * @since 3.0
 */
class Invoice extends \app\api\base\ActiveRecord
{
    const TYPE_OUTGOING = 10; // 
    const TYPE_INCOMING = 20;
    // status
    const STATUS_DRAFT = 10;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%invoice}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['status'], 'default', 'value' => self::STATUS_DRAFT],
            [['reff_type'], 'resolveType'],
            [['date', 'due_date', 'type', 'vendor_id', 'status', 'invoiceDtls'], 'required'],
            [['type'], 'in', 'range' => [self::TYPE_OUTGOING, self::TYPE_INCOMING]],
            [['date', 'due_date', 'created_at', 'updated_at'], 'safe'],
            [['type', 'vendor_id', 'status', 'created_by', 'updated_by'], 'integer'],
            [['value'], 'number'],
            [['number'], 'string', 'max' => 16],
            [['invoiceDtls'], 'checkDetail'],
        ];
    }

    /**
     * Get reference configuration
     * @param type $reff_type
     * @return null
     */
    public static function reffConfig($reff_type)
    {
        return Configs::invoice($reff_type);
    }

    public function getReffConfig()
    {
        return Configs::invoice($this->reff_type);
    }

    public function resolveType()
    {
        if (($config = Configs::movement($this->reff_type) !== null)) {
            $this->type = $config['type'];
        } else {
            $this->addError('reff_type', "Reference type {$this->reff_type} not recognize");
        }
    }

    public function checkDetail()
    {
        $value = 0.0;
        foreach ($this->invoiceDtls as $detail) {
            $value += $detail->value;
        }
        $this->value = $value;
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'number' => 'Number',
            'date' => 'Date',
            'due_date' => 'Due Date',
            'type' => 'Type',
            'vendor_id' => 'Vendor ID',
            'value' => 'Value',
            'status' => 'Status',
            'created_at' => 'Created At',
            'created_by' => 'Created By',
            'updated_at' => 'Updated At',
            'updated_by' => 'Updated By',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPaymentDtls()
    {
        return $this->hasMany(PaymentDtl::className(), ['invoice_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPayments()
    {
        return $this->hasMany(Payment::className(), ['id' => 'payment_id'])->viaTable('{{%payment_dtl}}', ['invoice_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getInvoiceDtls()
    {
        return $this->hasMany(InvoiceDtl::className(), ['invoice_id' => 'id']);
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return[
            'BizTimestampBehavior',
            'BizBlameableBehavior',
            [
                'class' => 'mdm\autonumber\Behavior',
                'digit' => 6,
                'attribute' => 'number',
                'value' => 'AI' . date('y.?')
            ],
            'BizStatusConverter',
            'mdm\behaviors\ar\RelationBehavior',
        ];
    }
}