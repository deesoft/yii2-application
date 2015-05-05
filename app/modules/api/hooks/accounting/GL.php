<?php

namespace app\api\hooks\accounting;

use Yii;
use dee\base\Event;
use app\api\components\accounting\GL as ApiGL;
use yii\base\UserException;

/**
 * Description of GL
 *
 * @author Misbahul D Munir <misbahuldmunir@gmail.com>  
 * @since 3.0
 */
class GL extends \yii\base\Behavior
{

    public function events()
    {
        return[
            'e_invoice_posted' => 'invoicePosted'
        ];
    }

    protected function createGL($data)
    {
        $model = ApiGL::create($data);
        if ($model->hasErrors()) {
            throw new UserException(implode("\n", $model->firstErrors));
        }
    }

    /**
     *
     * @param Event $event
     */
    public function invoicePosted($event)
    {
        /* @var $model \app\api\models\accounting\Invoice */
        $model = $event->params[0];
        $value = 0;
        foreach ($model->invoiceDtls as $detail) {
            $value += $detail->trans_value;
        }
        $data = [
            'entry_sheet' => ''
        ];
        $this->createGL($data);
    }

    /**
     *
     * @param Event $event
     */
    public function paymentPosted($event)
    {
        /* @var $model \app\api\models\accounting\Payment */
        $model = $event->params[0];
        $value = 0;
        foreach ($model->paymentDtls as $detail) {
            $value += $detail->trans_value;
        }
        $data = [
            'entry_sheet' => ''
        ];
        $this->createGL($data);
    }
}
