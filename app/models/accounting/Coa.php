<?php

namespace app\models\accounting;
use yii\helpers\ArrayHelper;

/**
 * Coa
 *
 * @author Misbahul D Munir <misbahuldmunir@gmail.com>
 * @since 1.0
 */
class Coa extends \biz\core\models\accounting\Coa
{    
    public $nmParent;
    
    public static function selectGroup()
    {
        return ArrayHelper::map(static::find()->where('code::INT % 100000 = 0')->asArray()->all(), 'code', 'name');
    }
        
}