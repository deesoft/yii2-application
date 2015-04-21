<?php

namespace app\api\models\master;

use yii\helpers\ArrayHelper;

/**
 * Category
 *
 * @author Misbahul D Munir <misbahuldmunir@gmail.com>
 * @since 1.0
 */
class Category extends \biz\api\models\master\Category
{

    public static function selectOptions()
    {
        return ArrayHelper::map(static::find()->all(), 'id', 'name');
    }
}