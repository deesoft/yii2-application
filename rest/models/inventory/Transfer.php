<?php

namespace rest\models\inventory;

use Yii;
use rest\classes\ActiveRecord;
use rest\models\master\Branch;


/**
 * This is the model class for table "{{%transfer}}".
 *
 * @property integer $id
 * @property string $number
 * @property integer $branch_id
 * @property integer $branch_dest_id
 * @property string $date
 * @property integer $status
 * @property string $created_at
 * @property integer $created_by
 * @property string $updated_at
 * @property integer $updated_by
 *
 * @property TransferDtl[] $items
 * 
 * @author Misbahul D Munir <misbahuldmunir@gmail.com>  
 * @since 3.0
 */
class Transfer extends ActiveRecord
{
    const STATUS_DRAFT = 10;
    const STATUS_PROCESS = 20;
    const STATUS_CLOSE = 90;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%transfer}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['branch_id', 'branch_dest_id', 'date', 'items'], 'required'],
            [['status'], 'default', 'value' => static::STATUS_DRAFT],
            [['branch_id', 'branch_dest_id', 'status', 'created_by', 'updated_by'], 'integer'],
            [['date', 'created_at', 'updated_at'], 'safe'],
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
            'branch_dest_id' => 'Branch Dest ID',
            'date' => 'Date',
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
        return $this->hasMany(TransferDtl::className(), ['transfer_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBranch()
    {
        return $this->hasOne(Branch::className(), ['id'=>'branch_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBranchDest()
    {
        return $this->hasOne(Branch::className(), ['id'=>'branch_dest_id']);
    }

    public function getIssues()
    {
        return $this->hasMany(GoodsMovement::className(), ['reff_id' => 'id'])
                ->onCondition(['reff_type' => 300]);
    }

    public function getReceives()
    {
        return $this->hasMany(GoodsMovement::className(), ['reff_id' => 'id'])
                ->onCondition(['reff_type' => 400]);
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
                'value' => 'IT' . date('y.?')
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
            'branch',
            'branchDest',
            'issues',
            'receives',
        ];
    }
}