<?php

namespace app\api\controllers\purchase;

/**
 * Description of PurchaseController
 *
 * @author Misbahul D Munir <misbahuldmunir@gmail.com>
 * @since 1.0
 */
class PurchaseController extends \biz\api\controllers\purchase\PurchaseController
{
    /**
     * @inheritdoc
     */
    public $modelClass = 'app\api\models\purchase\Purchase';

}