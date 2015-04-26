<?php

namespace app\api\models\master;

use Yii;

/**
 * This is the model class for table "{{%cogs}}".
 *
 * @property integer $product_id
 * @property double $cogs
 * @property string $created_at
 * @property integer $created_by
 * @property string $updated_at
 * @property integer $updated_by
 *
 * @property Product $product
 * 
 * @author Misbahul D Munir <misbahuldmunir@gmail.com>  
 * @since 3.0
 */
class Cogs extends \app\api\base\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%cogs}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['product_id', 'cogs'], 'required'],
            [['product_id', 'created_by', 'updated_by'], 'integer'],
            [['cogs'], 'number'],
            [['created_at', 'updated_at'], 'safe']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'product_id' => 'Product ID',
            'cogs' => 'Cogs',
            'created_at' => 'Created At',
            'created_by' => 'Created By',
            'updated_at' => 'Updated At',
            'updated_by' => 'Updated By',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProduct()
    {
        return $this->hasOne(Product::className(), ['id' => 'product_id']);
    }
    
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return[
            'BizTimestampBehavior',
            'BizBlameableBehavior'
        ];
    }
}
