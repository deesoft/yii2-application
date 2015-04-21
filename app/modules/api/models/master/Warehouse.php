<?php

namespace app\api\models\master;

use yii\helpers\ArrayHelper;

/**
 * Warehouse
 *
 * @author Misbahul D Munir <misbahuldmunir@gmail.com>
 * @since 1.0
 */
class Warehouse extends \biz\api\models\master\Warehouse
{

    public static function selectOptions($branch_id = null)
    {
        return ArrayHelper::map(static::find()->andFilterWhere([
                    'branch_id' => $branch_id
                ])->asArray()->all(), 'id', 'name');
    }
}