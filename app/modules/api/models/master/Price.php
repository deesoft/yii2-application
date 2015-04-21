<?php

namespace app\api\models\master;

use Yii;
use app\api\models\master\Product;

/**
 * Price
 *
 * @author Misbahul D Munir <misbahuldmunir@gmail.com>
 * @since 1.0
 */
class Price extends \biz\api\models\master\Price
{

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return array_merge(parent::rules(), [
            [['nmProduct'], 'required'],
            [['nmProduct'], 'in', 'range' => Product::find()->select('name')->column()]
        ]);
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return array_merge(parent::attributeLabels(), ['nmProduct' => 'Product Name']);
    }

    public function behaviors()
    {
        return array_merge(parent::behaviors(), [
            [
                'class' => 'mdm\converter\RelatedConverter',
                'attributes' => [
                    'nmProduct' => [[Product::className(), 'id' => 'product_id'], 'name'],
                ],
            ],
        ]);
    }
}