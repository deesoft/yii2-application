<?php

namespace app\api\models\inventory;

use Yii;
use app\api\base\Configs;
use app\api\base\ActiveRecord;
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

    /**
     * Get reference configuration
     * @param type $reff_type
     * @return null
     */
    public static function reffConfig($reff_type)
    {
        return Configs::movement($reff_type);
    }

    public function getReffConfig()
    {
        return Configs::movement($this->reff_type);
    }

    /**
     * Set type of document depending reference document
     */
    public function resolveType()
    {
        if (($config = Configs::movement($this->reff_type)) !== null) {
            $this->type = $config['type'];
        } else {
            $this->addError('reff_type', "Reference type {$this->reff_type} not recognize");
        }
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getReffDoc()
    {
        if (($config = $this->reffConfig) && isset($config['class'])) {
            return $this->hasOne($config['class'], ['id' => 'reff_id']);
        }
        return null;
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getReffDocDtls()
    {
        if (($reff = $this->reffDoc) !== null) {
            $config = $this->reffConfig;
            $relation = $reff->getRelation($config['relation']);
            return $this->hasMany($relation->modelClass, $relation->link)
                    ->via('reffDoc')
                    ->indexBy('product_id');
        }
        return null;
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
                'value' => 'IM' . date('ymd.?')
            ],
            'BizStatusConverter',
            [
                'class' => 'mdm\behaviors\ar\RelationBehavior',
                'beforeRSave' => function($child) {
                return !empty($child->qty);
            }
            ],
        ];
    }
}