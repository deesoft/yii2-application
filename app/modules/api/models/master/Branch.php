<?php

namespace app\api\models\master;

use yii\helpers\ArrayHelper;

/**
 * Branch
 *
 * @author Misbahul D Munir <misbahuldmunir@gmail.com>
 * @since 1.0
 */
class Branch extends \biz\api\models\master\Branch
{

    public static function selectOptions($orgn_id = null)
    {
        return ArrayHelper::map(static::find()->andFilterWhere([
                    'orgn_id' => $orgn_id
                ])->all(), 'id', 'name');
    }
}