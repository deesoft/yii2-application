<?php

namespace app\models\accounting;

/**
 * Invoice
 *
 * @property InvoiceDtl[] $invoiceDtls
 * 
 * @author Misbahul D Munir <misbahuldmunir@gmail.com>
 * @since 1.0
 */
class Invoice extends \biz\core\models\accounting\Invoice
{

    /**
     * @inheritdoc
     */
    public function getInvoiceDtls()
    {
        return $this->hasMany(InvoiceDtl::className(), ['invoice_id' => 'id']);
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        $behaviors = parent::behaviors();
        return array_merge($behaviors, [
            [
                'class' => 'mdm\converter\DateConverter',
                'attributes' => [
                    'Date' => 'date',
                    'DueDate' => 'due_date'
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