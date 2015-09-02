<?php

namespace rest\classes;

use yii\base\Behavior;

/**
 * Description of Hooks
 *
 * @author Misbahul D Munir <misbahuldmunir@gmail.com>
 * @since 1.0
 */
class Hooks extends Behavior
{
    private $_defaults = [
        'ProductStock' => 'rest\hooks\ProductStock',
        'Purchase' => 'rest\hooks\Purchase',
        'Sales' => 'rest\hooks\Sales',
        'Transfer' => 'rest\hooks\Transfer',
    ];
    public $hooks = [];

    /**
     *
     * @param \yii\base\Component $owner
     */
    public function attach($owner)
    {
        $behaviors = array_filter(array_merge($this->_defaults, $this->hooks));
        $owner->attachBehaviors($behaviors);
    }
}