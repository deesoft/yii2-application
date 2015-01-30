<?php

namespace app\models\master;

use yii\helpers\ArrayHelper;

/**
 * Supplier
 *
 * @author Misbahul D Munir <misbahuldmunir@gmail.com>
 * @since 1.0
 */
class Supplier extends \biz\core\models\master\Supplier
{
    
    public static function selectOptions()
    {
        return ArrayHelper::map(static::find()->asArray()->all(), 'id', 'name');
    }
}