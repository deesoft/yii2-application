<?php

namespace app\api\models\master;

use yii\helpers\ArrayHelper;

/**
 * Uom
 *
 * @author Misbahul D Munir <misbahuldmunir@gmail.com>
 * @since 1.0
 */
class Uom extends \biz\api\models\master\Uom
{

    public static function selectOptions()
    {
        return ArrayHelper::map(static::find()->all(), 'id', 'name');
    }
}