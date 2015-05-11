<?php

namespace app\api\models\master;

use Yii;

/**
 * This is the model class for table "{{%price}}".
 *
 * @property integer $product_id
 * @property integer $price_category_id
 * @property double $price
 * @property string $created_at
 * @property integer $created_by
 * @property string $updated_at
 * @property integer $updated_by
 *
 * @property Product $product
 * @property PriceCategory $priceCategory
 * 
 * @author Misbahul D Munir <misbahuldmunir@gmail.com>  
 * @since 3.0
 */
class Price extends \app\api\base\ActiveRecord {

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return '{{%price}}';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['product_id', 'price_category_id', 'price'], 'required'],
            [['product_id', 'price_category_id', 'created_by', 'updated_by'], 'integer'],
            [['product_id', 'price_category_id'], 'unique', 'targetAttribute' => ['product_id', 'price_category_id']],
            [['price'], 'number'],
            [['created_at', 'updated_at'], 'safe']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'product_id' => 'Product ID',
            'price_category_id' => 'Price Category ID',
            'price' => 'Price',
            'created_at' => 'Created At',
            'created_by' => 'Created By',
            'updated_at' => 'Updated At',
            'updated_by' => 'Updated By',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProduct() {
        return $this->hasOne(Product::className(), ['id' => 'product_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPriceCategory() {
        return $this->hasOne(PriceCategory::className(), ['id' => 'price_category_id']);
    }

    /**
     * @inheritdoc
     */
    public function behaviors() {
        return[
            'yii\behaviors\TimestampBehavior',
            'yii\behaviors\BlameableBehavior'
        ];
    }

}
