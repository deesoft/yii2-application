<?php

namespace rest\models\purchase;

use Yii;
use rest\classes\ActiveRecord;
use rest\models\master\Branch;
use rest\models\master\Supplier;
use rest\models\inventory\GoodsMovement;

/**
 * Description of Purchase
 * 
 * @property integer $id
 * @property string $number
 * @property integer $supplier_id
 * @property integer $branch_id
 * @property string $date
 * @property double $value
 * @property double $discount
 * @property integer $status
 * @property string $created_at
 * @property integer $created_by
 * @property string $updated_at
 * @property integer $updated_by
 *
 * @property PurchaseDtl[] $items
 * @property GoodsMovement[] $movements
 * @author Misbahul D Munir <misbahuldmunir@gmail.com>
 */
class Purchase extends ActiveRecord
{
    const STATUS_DRAFT = 10;
    const STATUS_PROCESS = 20;
    const STATUS_CLOSE = 90;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%purchase}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['status'], 'default', 'value' => self::STATUS_DRAFT],
            [['items'],'resolveValue'],
            [['supplier_id', 'branch_id', 'date', 'value', 'items'], 'required'],
            [['supplier_id', 'branch_id', 'status'], 'integer'],
            [['status'], 'in', 'range' => [self::STATUS_DRAFT, self::STATUS_PROCESS, self::STATUS_CLOSE]],
            [['discount', 'value'], 'number'],
            [['number'], 'string', 'max' => 16],
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
            'supplier_id' => 'Supplier ID',
            'branch_id' => 'Branch ID',
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

    public function getItems()
    {
        return $this->hasMany(PurchaseDtl::className(), ['purchase_id' => 'id']);
    }

    public function getMovements()
    {
        return $this->hasMany(GoodsMovement::className(), ['reff_id' => 'id'])
                ->onCondition(['reff_type' => 100]);
    }

    public function getSupplier()
    {
        return $this->hasOne(Supplier::className(), ['id' => 'supplier_id']);
    }

    public function getBranch()
    {
        return $this->hasOne(Branch::className(), ['id' => 'branch_id']);
    }

    public function behaviors()
    {
        return[
            'yii\behaviors\TimestampBehavior',
            'yii\behaviors\BlameableBehavior',
            [
                'class' => 'mdm\autonumber\Behavior',
                'digit' => 6,
                'attribute' => 'number',
                'value' => 'PU' . date('y.?')
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
            'supplier',
            'branch',
            'movements'
        ];
    }
}