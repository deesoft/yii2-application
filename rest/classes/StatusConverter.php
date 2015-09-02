<?php

namespace rest\classes;

/**
 * Description of StatusConverter
 *
 * @author Misbahul D Munir <misbahuldmunir@gmail.com>
 * @since 1.0
 */
class StatusConverter extends \mdm\converter\EnumConverter
{

    /**
     * @var string
     */
    public $enumPrefix = 'STATUS_';

    public $attributes = [
        'nmStatus' => 'status',
    ];
}