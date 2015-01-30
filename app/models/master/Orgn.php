<?php

namespace app\models\master;

use yii\helpers\ArrayHelper;

/**
 * Orgn
 *
 * @author Misbahul D Munir <misbahuldmunir@gmail.com>
 * @since 1.0
 */
class Orgn extends \biz\core\models\master\Orgn
{

    public static function selectOptions()
    {
        return ArrayHelper::map(static::find()->all(), 'id', 'name');
    }
}