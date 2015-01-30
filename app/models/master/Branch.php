<?php

namespace app\models\master;

use yii\helpers\ArrayHelper;

/**
 * Branch
 *
 * @author Misbahul D Munir <misbahuldmunir@gmail.com>
 * @since 1.0
 */
class Branch extends \biz\core\models\master\Branch
{

    public static function selectOptions($orgn_id = null)
    {
        return ArrayHelper::map(static::find()->andFilterWhere([
                    'orgn_id' => $orgn_id
                ])->all(), 'id', 'name');
    }
}