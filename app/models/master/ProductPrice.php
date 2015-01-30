<?php

namespace app\models\master;

use app\models\master\Price;

/**
 * ProductPrice
 *
 * @author Misbahul D Munir <misbahuldmunir@gmail.com>
 * @since 1.0
 */
class ProductPrice extends \yii\base\Model
{
    public $id;
    public $name;
    public $category;
    public $price;
    public $prices = [];

    public function rules()
    {
        return[
            [['id'], 'required'],
            [['prices'], 'checkPrices'],
        ];
    }

    public function checkPrices()
    {
        foreach ($this->prices as $key => $value) {
            $value = trim($value);
            if (empty($value)) {
                unset($this->prices[$key]);
                continue;
            }
            if (!is_numeric($value) || $value < 0) {
                $this->addError('prices', 'Price must numeric great than zero');
                break;
            }
        }
    }

    public function save($validate = true)
    {
        if ($validate && !$this->validate()) {
            return false;
        }

        foreach ($this->prices as $ct_id => $value) {
            $model = Price::findOne(['product_id' => $this->id, 'price_category_id' => $ct_id]);
            $model = $model ? : new Price(['product_id' => $this->id, 'price_category_id' => $ct_id]);
            $model->price = $value;
            if (!$model->save()) {
                return false;
            }
        }
        return true;
    }
}