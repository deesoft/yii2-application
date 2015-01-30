<?php

namespace app\models\inventory;

use Yii;
use yii\helpers\Html;
use biz\core\base\Configs;

/**
 * GoodsMovement
 *
 * @property GoodsMovementDtl[] $goodsMovementDtls
 * 
 * @author Misbahul D Munir <misbahuldmunir@gmail.com>
 * @since 1.0
 */
class GoodsMovement extends \biz\core\models\inventory\GoodsMovement
{

    public function getGoodsMovementDtls()
    {
        return $this->hasMany(GoodsMovementDtl::className(), ['movement_id' => 'id']);
    }

    public function rules()
    {
        return array_merge([
            [['Date'], 'required'],
            ], parent::rules(), [
            [['goodsMovementDtls'], 'caclTransValue']
        ]);
    }

    public function caclTransValue()
    {
        $value = 0;
        foreach ($this->goodsMovementDtls as $detail) {
            $value += $detail->qty * $detail->trans_value;
        }
        $this->trans_value = $value;
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getWarehouse()
    {
        return $this->hasOne(\biz\core\models\master\Warehouse::className(), ['id' => 'warehouse_id']);
    }

    public function getNmReffType()
    {
        if (($config = $this->reffConfig) !== null) {
            return isset($config['name']) ? $config['name'] : null;
        }
        return null;
    }

    public function getReffLink()
    {
        if (($config = $this->reffConfig) !== null && isset($config['link'])) {
            return $this->reffDoc ? Html::a($this->reffDoc->number, [$config['link'], 'id' => $this->reffDoc->id]) : null;
        }
        return null;
    }

    /**
     * 
     * @param sting $name
     * @return boolean
     */
    public function visibleButton($name)
    {
        switch ($name) {
            case 'update':
            case 'delete':
            case 'apply':
                return $this->status == static::STATUS_DRAFT;
            default:
                return true;
        }
    }

    public function behaviors()
    {
        $behaviors = parent::behaviors();
        return array_merge($behaviors, [
            [
                'class' => 'mdm\converter\DateConverter',
                'attributes' => [
                    'Date' => 'date',
                ]
            ],
            [
                'class' => 'mdm\converter\EnumConverter',
                'attributes' => [
                    'nmType' => 'type'
                ],
                'enumPrefix' => 'TYPE_'
            ],
        ]);
    }
}
// Extend reference
Configs::merge('movement', '@app/config/biz/movement.php');
