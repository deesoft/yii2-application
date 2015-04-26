<?php

namespace app\api\models\accounting;

use Yii;

/**
 * This is the model class for table "{{%gl_detail}}".
 *
 * @property integer $id
 * @property integer $header_id
 * @property integer $coa_id
 * @property double $amount
 *
 * @property GlHeader $header
 * @property Coa $coa
 *
 * @author Misbahul D Munir <misbahuldmunir@gmail.com>
 * @since 3.0
 */
class GlDetail extends \app\api\base\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%gl_detail}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['header_id', 'coa_id', 'amount'], 'required'],
            [['header_id', 'coa_id'], 'integer'],
            [['amount'], 'number']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'header_id' => 'Header ID',
            'coa_id' => 'Coa ID',
            'amount' => 'Amount',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getHeader()
    {
        return $this->hasOne(GlHeader::className(), ['id' => 'header_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCoa()
    {
        return $this->hasOne(Coa::className(), ['id' => 'coa_id']);
    }
}
