<?php

namespace app\api\models\accounting;

use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "{{%coa}}".
 *
 * @property integer $id
 * @property integer $parent_id
 * @property string $code
 * @property string $name
 * @property integer $type
 * @property string $normal_balance
 * @property string $created_at
 * @property integer $created_by
 * @property string $updated_at
 * @property integer $updated_by
 *
 * @property GlDetail[] $glDetails
 * @property Coa $parent
 * @property Coa[] $coas
 * @property EntriSheetDtl[] $entriSheetDtls
 *
 * @author Misbahul D Munir <misbahuldmunir@gmail.com>
 * @since 3.0
 */
class Coa extends \app\api\base\ActiveRecord
{

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%coa}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['code', 'name', 'type', 'normal_balance'], 'required'],
            [['parent_id', 'type', 'created_by', 'updated_by'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['code'], 'string', 'max' => 16],
            [['name'], 'string', 'max' => 64],
            [['normal_balance'], 'string', 'max' => 1]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'parent_id' => 'Parent ID',
            'code' => 'Code',
            'name' => 'Name',
            'type' => 'Coa Group',
            'normal_balance' => 'Normal Balance',
            'created_at' => 'Created At',
            'created_by' => 'Created By',
            'updated_at' => 'Updated At',
            'updated_by' => 'Updated By',
        ];
    }

    public static function selectGroup()
    {
        return ArrayHelper::map(static::find()->where('code::INT % 100000 = 0')->asArray()->all(), 'code', 'name');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getGlDetails()
    {
        return $this->hasMany(GlDetail::className(), ['coa_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getParent()
    {
        return $this->hasOne(Coa::className(), ['id' => 'parent_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getGroup()
    {
        return $this->hasOne(Coa::className(), ['code' => 'type']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCoas()
    {
        return $this->hasMany(Coa::className(), ['parent_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEntriSheetDtls()
    {
        return $this->hasMany(EntriSheetDtl::className(), ['coa_id' => 'id']);
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return[
            'BizTimestampBehavior',
            'BizBlameableBehavior',
        ];
    }
}