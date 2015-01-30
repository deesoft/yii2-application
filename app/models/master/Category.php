<?php

namespace app\models\master;

use yii\helpers\ArrayHelper;

/**
 * Category
 *
 * @author Misbahul D Munir <misbahuldmunir@gmail.com>
 * @since 1.0
 */
class Category extends \biz\core\models\master\Category
{

    public static function selectOptions()
    {
        return ArrayHelper::map(static::find()->all(), 'id', 'name');
    }
}