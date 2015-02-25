<?php

namespace app\models\purchase;

use Yii;
use app\models\master\Branch;
use app\models\master\Supplier;
use app\models\inventory\GoodsMovement;

/**
 * Description of Purchase
 *
 * @property PurchaseDtl[] $purchaseDtls
 * @property GoodsMovement[] $grs
 * @author Misbahul D Munir <misbahuldmunir@gmail.com>
 */
class Purchase extends \biz\core\models\purchase\Purchase
{

    public function rules()
    {
        $rules = parent::rules();
        return array_merge([
//            [['nmSupplier', 'Date'], 'required'],
//            [['nmSupplier'], 'in', 'range' => Supplier::find()->select('name')->column()],
            ], $rules);
    }

    public function calcDetails()
    {
        $value = 0.0;
        foreach ($this->purchaseDtls as $detail) {
            $value += $detail->qty * $detail->price * $detail->productUom->isi * (1.0 - 0.01 * $detail->discount);
        }
        $this->value = $value;
    }

    public function getPurchaseDtls()
    {
        return $this->hasMany(PurchaseDtl::className(), ['purchase_id' => 'id']);
    }

    public function getGrs()
    {
        return $this->hasMany(GoodsMovement::className(), ['reff_id' => 'id'])
                ->onCondition(['reff_type' => 100]);
    }

    public function getSupplier()
    {
        return $this->hasOne(Supplier::className(), ['id' => 'supplier_id']);
    }

    public function getBranch()
    {
        return $this->hasOne(Branch::className(), ['id' => 'branch_id']);
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
                'class' => 'mdm\converter\RelatedConverter',
                'attributes' => [
                    'nmSupplier' => [[Supplier::className(), 'id' => 'supplier_id'], 'name'],
                ],
            ],
        ]);
    }
    
    public function extraFields()
    {
        return[
            'details'=>'purchaseDtls',
            'supplier',
            'branch'
        ];
    }
}