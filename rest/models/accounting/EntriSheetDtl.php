<?php

namespace rest\models\accounting;

use Yii;

/**
 * This is the model class for table "{{%entri_sheet_dtl}}".
 *
 * @property string $esheet_id
 * @property string $id
 * @property string $name
 * @property integer $coa_id
 *
 * @property EntriSheet $esheet
 * @property Coa $coa
 *
 * @author Misbahul D Munir <misbahuldmunir@gmail.com>
 * @since 3.0
 */
class EntriSheetDtl extends \rest\classes\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%entri_sheet_dtl}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['esheet_id', 'id', 'coa_id'], 'required'],
            [['coa_id'], 'integer'],
            [['esheet_id', 'id'], 'string', 'max' => 16],
            [['name'], 'string', 'max' => 64]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'esheet_id' => 'Esheet ID',
            'id' => 'ID',
            'name' => 'Name',
            'coa_id' => 'Coa ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEsheet()
    {
        return $this->hasOne(EntriSheet::className(), ['id' => 'esheet_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCoa()
    {
        return $this->hasOne(Coa::className(), ['id' => 'coa_id']);
    }
}
