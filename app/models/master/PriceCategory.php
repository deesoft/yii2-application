<?php

namespace app\models\master;

use yii\helpers\ArrayHelper;
/**
 * Price category
 *
 * @author Misbahul D Munir <misbahuldmunir@gmail.com>
 * @since 1.0
 */
class PriceCategory extends \biz\core\models\master\PriceCategory
{

    public static function selectOptions()
    {
        return ArrayHelper::map(static::find()->all(), 'id', 'name');
    }
}