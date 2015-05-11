<?php

namespace app\api\models\sales;

use Yii;

/**
 * This is the model class for table "{{%sales}}".
 *
 * @property integer $id
 * @property string $number
 * @property integer $branch_id
 * @property integer $customer_id
 * @property string $date
 * @property double $value
 * @property double $discount
 * @property integer $status
 * @property string $created_at
 * @property integer $created_by
 * @property string $updated_at
 * @property integer $updated_by
 *
 * @property SalesDtl[] $salesDtls
 * 
 * @author Misbahul D Munir <misbahuldmunir@gmail.com>  
 * @since 3.0
 */
class Sales extends \app\api\base\ActiveRecord
{
    // status sales
    const STATUS_DRAFT = 10;
    const STATUS_PROCESS = 20;
    const STATUS_CLOSE = 90;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%sales}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['branch_id', 'date', 'value'], 'required'],
            [['branch_id', 'customer_id', 'status', 'created_by', 'updated_by'], 'integer'],
            [['status'], 'default', 'value' => static::STATUS_DRAFT],
            [['date', 'created_at', 'updated_at'], 'safe'],
            [['value', 'discount'], 'number'],
            [['number'], 'string', 'max' => 16]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'number' => 'Number',
            'branch_id' => 'Branch ID',
            'customer_id' => 'Customer ID',
            'date' => 'Date',
            'value' => 'Value',
            'discount' => 'Discount',
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
    public function getSalesDtls()
    {
        return $this->hasMany(SalesDtl::className(), ['sales_id' => 'id']);
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return[
            'yii\behaviors\TimestampBehavior',
            'yii\behaviors\BlameableBehavior',
            [
                'class' => 'mdm\autonumber\Behavior',
                'digit' => 6,
                'attribute' => 'number',
                'value' => 'SA' . date('y.?')
            ],
            'app\api\base\StatusConverter',
            'mdm\behaviors\ar\RelationBehavior',
        ];
    }
}