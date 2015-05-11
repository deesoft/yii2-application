<?php

namespace app\api\models\inventory;

use Yii;
use app\api\base\ActiveRecord;
use app\api\models\master\Warehouse;

/**
 * This is the model class for table "{{%goods_movement}}".
 *
 * @property integer $id
 * @property string $number
 * @property string $date
 * @property integer $type
 * @property integer $reff_type
 * @property integer $reff_id
 * @property string $description
 * @property integer $warehouse_id
 * @property integer $status
 * @property double $trans_value
 * @property double $total_invoiced
 * @property string $created_at
 * @property integer $created_by
 * @property string $updated_at
 * @property integer $updated_by
 * 
 * @property ActiveRecord $reffDoc
 * @property ActiveRecord[] $reffDocDtls
 * @property GoodsMovementDtl[] $items
 * @property string $reffLink
 * 
 * @property array $reffConfig
 * 
 * @author Misbahul D Munir <misbahuldmunir@gmail.com>  
 * @since 3.0
 */
class GoodsMovement extends ActiveRecord
{
    // status GoodsMovement
    const STATUS_DRAFT = 10;
    const STATUS_APPLIED = 20;
    const STATUS_CLOSE = 90;
    // type movement
    const TYPE_RECEIVE = 10;
    const TYPE_ISSUE = 20;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%goods_movement}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['status'], 'default', 'value' => self::STATUS_DRAFT],
            [['date', 'warehouse_id', 'type', 'items'], 'required'],
            [['type'], 'in', 'range' => [self::TYPE_RECEIVE, self::TYPE_ISSUE]],
            [['reff_type', 'reff_id', 'warehouse_id', 'status', 'created_by', 'updated_by'], 'integer'],
            [['number'], 'string', 'max' => 16],
            [['trans_value', 'total_invoiced'], 'number'],
            [['description'], 'string', 'max' => 255],
            [['reff_id'], 'unique', 'targetAttribute' => ['reff_id', 'reff_type', 'status'],
                'when' => function($obj) {
                return $obj->status == self::STATUS_DRAFT && $obj->reff_type != null;
            }
            ],
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
            'date' => 'Date',
            'type' => 'Type',
            'warehouse_id' => 'Warehouse ID',
            'reff_type' => 'Reff Type',
            'reff_id' => 'Reff ID',
            'description' => 'Description',
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
        return $this->hasMany(GoodsMovementDtl::className(), ['movement_id' => 'id']);
    }

    public function getWarehouse()
    {
        return $this->hasOne(Warehouse::className(), ['id'=>'warehouse_id']);
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
                'value' => 'IM' . date('ymd.?')
            ],
            'app\api\base\StatusConverter',
            [
                'class' => 'mdm\behaviors\ar\RelationBehavior',
                'beforeRSave' => function($child) {
                return !empty($child->qty);
            }
            ],
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
            'warehouse',
        ];
    }
}