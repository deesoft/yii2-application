<?php

namespace app\api\models\master;

use yii\helpers\ArrayHelper;
/**
 * Customer
 *
 * @author Misbahul D Munir <misbahuldmunir@gmail.com>
 * @since 1.0
 */
class Customer extends \biz\api\models\master\Customer
{

    public static function selectOptions()
    {
        return ArrayHelper::map(static::find()->asArray()->all(), 'id', 'name');
    }
}