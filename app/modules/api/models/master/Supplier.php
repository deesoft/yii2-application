<?php

namespace app\api\models\master;

use yii\helpers\ArrayHelper;

/**
 * Supplier
 *
 * @author Misbahul D Munir <misbahuldmunir@gmail.com>
 * @since 1.0
 */
class Supplier extends \biz\api\models\master\Supplier
{
    
    public static function selectOptions()
    {
        return ArrayHelper::map(static::find()->asArray()->all(), 'id', 'name');
    }
}