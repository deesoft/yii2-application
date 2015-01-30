<?php

namespace app\models\inventory;

use Yii;
use app\models\master\Branch;

/**
 * Transfer
 *
 * @property TransferDtl[] $transferDtls
 * 
 * @author Misbahul D Munir <misbahuldmunir@gmail.com>
 * @since 1.0
 */
class Transfer extends \biz\core\models\inventory\Transfer
{

    public function rules()
    {
        $rules = parent::rules();
        return array_merge([
             [['Date'], 'required'],
            ], $rules);
    }

    public function getTransferDtls()
    {
        return $this->hasMany(TransferDtl::className(), ['transfer_id' => 'id']);
    }

    public function getBranch()
    {
        return $this->hasOne(Branch::className(), ['id'=>'branch_id']);
    }

    public function getDestBranch()
    {
        return $this->hasOne(Branch::className(), ['id'=>'branch_dest_id']);
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
        ]);
    }
}