<?php

namespace rest\models\sales;

use Yii;
use rest\classes\ActiveRecord;
use rest\models\master\Branch;
use rest\models\master\Customer;
use rest\models\inventory\GoodsMovement;

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
 * @property SalesDtl[] $items
 * 
 * @author Misbahul D Munir <misbahuldmunir@gmail.com>  
 * @since 3.0
 */
class Sales extends ActiveRecord
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
            [['status'], 'default', 'value' => static::STATUS_DRAFT],
            [['items'],'resolveValue'],
            [['branch_id', 'date', 'value', 'items'], 'required'],
            [['branch_id', 'customer_id', 'status', 'created_by', 'updated_by'], 'integer'],
            [['value', 'discount'], 'number'],
            [['number'], 'string', 'max' => 16]
        ];
    }

    public function resolveValue()
    {
        $value = 0.0;
        foreach ($this->items as $item) {
            $value += $item->qty * $item->price;
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
    public function getItems()
    {
        return $this->hasMany(SalesDtl::className(), ['sales_id' => 'id']);
    }

    public function getMovements()
    {
        return $this->hasMany(GoodsMovement::className(), ['reff_id' => 'id'])
                ->onCondition(['reff_type' => 200]);
    }

    public function getCustomer()
    {
        return $this->hasOne(Customer::className(), ['id' => 'customer_id']);
    }

    public function getBranch()
    {
        return $this->hasOne(Branch::className(), ['id' => 'branch_id']);
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
            'rest\classes\StatusConverter',
            'mdm\behaviors\ar\RelationBehavior',
        ];
    }

    public function fields()
    {
        $fields = parent::fields();
        $fields['nmStatus'] = 'nmStatus';
        return $fields;
    }

    public function extraFields()
    {
        return[
            'items',
            'customer',
            'branch',
            'movements'
        ];
    }
}