<?php

namespace app\api\models\inventory;

use Yii;

/**
 * This is the model class for table "{{%stock_opname}}".
 *
 * @property integer $id
 * @property string $number
 * @property integer $warehouse_id
 * @property string $date
 * @property integer $status
 * @property string $description
 * @property string $operator
 * @property string $created_at
 * @property integer $created_by
 * @property string $updated_at
 * @property integer $updated_by
 *
 * @property StockOpnameDtl[] $stockOpnameDtls
 * 
 * @author Misbahul D Munir <misbahuldmunir@gmail.com>  
 * @since 3.0
 */
class StockOpname extends \app\api\base\ActiveRecord
{
    const STATUS_DRAFT = 10;
    const STATUS_PROCESS = 20;
    const STATUS_CLOSE = 90;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%stock_opname}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['warehouse_id', 'date', 'status'], 'required'],
            [['warehouse_id', 'status', 'created_by', 'updated_by'], 'integer'],
            [['date', 'created_at', 'updated_at'], 'safe'],
            [['number'], 'string', 'max' => 16],
            [['description', 'operator'], 'string', 'max' => 255]
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
            'warehouse_id' => 'Warehouse ID',
            'date' => 'Date',
            'status' => 'Status',
            'description' => 'Description',
            'operator' => 'Operator',
            'created_at' => 'Created At',
            'created_by' => 'Created By',
            'updated_at' => 'Updated At',
            'updated_by' => 'Updated By',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStockOpnameDtls()
    {
        return $this->hasMany(StockOpnameDtl::className(), ['opname_id' => 'id']);
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
                'value' => 'IO' . date('y.?')
            ],
            'app\api\base\StatusConverter',
            'mdm\behaviors\ar\RelationBehavior',
        ];
    }}
