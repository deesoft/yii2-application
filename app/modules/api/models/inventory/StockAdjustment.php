<?php

namespace app\api\models\inventory;

use Yii;

/**
 * This is the model class for table "{{%stock_adjustment}}".
 *
 * @property integer $id
 * @property string $number
 * @property integer $warehouse_id
 * @property string $date
 * @property integer $reff_id
 * @property string $description
 * @property integer $status
 * @property string $created_at
 * @property integer $created_by
 * @property string $updated_at
 * @property integer $updated_by
 *
 * @property StockAdjustmentDtl[] $stockAdjustmentDtls
 * 
 * @author Misbahul D Munir <misbahuldmunir@gmail.com>  
 * @since 3.0
 */
class StockAdjustment extends \app\api\base\ActiveRecord
{
    const STATUS_DRAFT = 10;
    const STATUS_APPLIED = 20;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%stock_adjustment}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['number', 'warehouse_id', 'date', 'status'], 'required'],
            [['warehouse_id', 'reff_id', 'status', 'created_by', 'updated_by'], 'integer'],
            [['date', 'created_at', 'updated_at'], 'safe'],
            [['number'], 'string', 'max' => 16],
            [['description'], 'string', 'max' => 255]
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
    public function getStockAdjustmentDtls()
    {
        return $this->hasMany(StockAdjustmentDtl::className(), ['adjustment_id' => 'id']);
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
                'value' => 'IA' . date('y.?')
            ],
            'app\api\base\StatusConverter',
            'mdm\behaviors\ar\RelationBehavior',
        ];
    }}
