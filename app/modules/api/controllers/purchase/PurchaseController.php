<?php

namespace app\api\controllers\purchase;

use Yii;
use app\api\base\Controller;
use app\api\models\purchase\Purchase as MPurchase;

/**
 * Description of PurchaseController
 *
 * @property ApiPurchase $api
 * @author Misbahul D Munir <misbahuldmunir@gmail.com>
 * @since 3.0
 */
class PurchaseController extends Controller
{
    /**
     * @inheritdoc
     */
    public $modelClass = 'app\api\models\purchase\Purchase';

    /**
     * @inheritdoc
     */
    public $prefixEventName = 'ePurchase';

    /**
     * @var array
     */
    protected $patchingStatus = [
        [MPurchase::STATUS_DRAFT, MPurchase::STATUS_PROCESS, 'process'],
        [MPurchase::STATUS_PROCESS, MPurchase::STATUS_DRAFT, 'reject'],
    ];

    /**
     * @inheritdoc
     */
    public function events()
    {
        return[
            'patch' => 'ePatch',
        ];
    }

    /**
     * @param \dee\base\Event $event
     */
    public function ePatch($event)
    {
        /* @var $model MPurchase */
        $model = $event->params[0];
        $dirty = $model->getDirtyAttributes();
        $olds = $model->getOldAttributes();
        // status changed
        if (isset($dirty['status'])) {
            foreach ($this->patchingStatus as $change) {
                if ($olds['status'] == $change[0] && $dirty['status'] == $change[1]) {
                    $this->fire($change[2], [$model]);
                }
            }
        }
    }
}