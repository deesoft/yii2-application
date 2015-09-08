<?php

namespace rest\models\master;

use Yii;

/**
 * This is the model class for table "{{%product}}".
 *
 * @property integer $id
 * @property integer $group_id
 * @property integer $category_id
 * @property string $code
 * @property string $name
 * @property integer $status
 * @property string $created_at
 * @property integer $created_by
 * @property string $updated_at
 * @property integer $updated_by
 *
 * @property Cogs $cogs
 * @property ProductGroup $group
 * @property Category $category
 * @property Price[] $prices
 * @property PriceCategory[] $priceCategories
 * @property ProductSupplier[] $productSuppliers
 * @property Supplier[] $suppliers
 * @property ProductStock[] $productStocks
 * @property Warehouse[] $warehouses
 * @property ProductUom[] $productUoms
 * @property Uom[] $uoms
 * @property ProductChild[] $productChildren
 * 
 * @author Misbahul D Munir <misbahuldmunir@gmail.com>  
 * @since 3.0
 */
class Product extends \rest\classes\ActiveRecord
{
    const STATUS_ACTIVE = 10;
    const STATUS_INACTIVE = 20;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%product}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['status'], 'default', 'value' => self::STATUS_ACTIVE],
            [['group_id', 'category_id', 'code', 'name'], 'required'],
            [['group_id', 'category_id', 'status', 'created_by', 'updated_by'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['code'], 'string', 'max' => 13],
            [['name'], 'string', 'max' => 64]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'group_id' => 'Group ID',
            'category_id' => 'Category ID',
            'code' => 'Code',
            'name' => 'Name',
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
    public function getCogs()
    {
        return $this->hasOne(Cogs::className(), ['product_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getGroup()
    {
        return $this->hasOne(ProductGroup::className(), ['id' => 'group_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCategory()
    {
        return $this->hasOne(Category::className(), ['id' => 'category_id']);
    }

    public function extraFields()
    {
        return[
            'group',
            'category',
        ];
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return[
            'yii\behaviors\TimestampBehavior',
            'yii\behaviors\BlameableBehavior',
            'rest\classes\StatusConverter',
        ];
    }
}