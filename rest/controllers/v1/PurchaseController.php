<?php

namespace rest\controllers\v1;

use Yii;
use rest\classes\AdvanceController;
use rest\models\purchase\Purchase as MPurchase;

/**
 * Description of PurchaseController
 *
 * @property ApiPurchase $api
 * @author Misbahul D Munir <misbahuldmunir@gmail.com>
 * @since 3.0
 */
class PurchaseController extends AdvanceController
{
    /**
     * @inheritdoc
     */
    public $modelClass = 'rest\models\purchase\Purchase';
    public $modelSearchClass = 'rest\models\purchase\searchs\Purchase';

    /**
     * @inheritdoc
     */
    public $prefixEventName = 'ePurchase';

    /**
     * @var array
     */
    protected $patchingStatus = [
        [MPurchase::STATUS_DRAFT, MPurchase::STATUS_PROCESS, 'process', 'processed'],
        [MPurchase::STATUS_PROCESS, MPurchase::STATUS_DRAFT, 'reject', 'rejected'],
    ];

    /**
     * @param \dee\base\Event $event
     */
    public function ePatch($event)
    {
        /* @var $model MPurchase */
        list($model, $dirty, $olds) = $event->params;
        // status changed
        if (isset($dirty['status'])) {
            foreach ($this->patchingStatus as $change) {
                if ($olds['status'] == $change[0] && $dirty['status'] == $change[1]) {
                    $this->fire($change[2], [$model]);
                }
            }
        }
    }

    /**
     * @param \dee\base\Event $event
     */
    public function ePatched($event)
    {
        /* @var $model MPurchase */
        list($model, $dirty, $olds) = $event->params;
        // status changed
        if (isset($dirty['status'])) {
            foreach ($this->patchingStatus as $change) {
                if ($olds['status'] == $change[0] && $dirty['status'] == $change[1]) {
                    $this->fire($change[3], [$model]);
                }
            }
        }
    }
}