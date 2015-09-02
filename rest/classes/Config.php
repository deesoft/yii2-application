<?php

namespace rest\classes;

use Yii;
use yii\base\Object;

/**
 * Description of Config
 *
 * @property array $movement
 * 
 * @author Misbahul D Munir <misbahuldmunir@gmail.com>
 * @since 1.0
 */
class Config extends Object
{
    private $_configs = [];

    protected function loadDefault($name)
    {
        if (!array_key_exists($name, $this->_configs)) {
            if (is_file(__DIR__ . "/defaults/{$name}.php")) {
                $this->_configs[$name] = require(__DIR__ . "/defaults/{$name}.php");
            } else {
                $this->_configs[$name] = [];
            }
        }
    }

    protected static function merge($a, $b)
    {
        $args = func_get_args();
        $res = array_shift($args);
        while (!empty($args)) {
            $next = array_shift($args);
            if (!is_array($res) || !is_array($next)) {
                $res = $next;
                continue;
            }
            foreach ($next as $k => $v) {
                if (is_array($v) && isset($res[$k]) && is_array($res[$k])) {
                    $res[$k] = self::merge($res[$k], $v);
                } else {
                    $res[$k] = $v;
                }
            }
        }

        return $res;
    }

    public function __get($name)
    {
        $this->loadDefault($name);
        return $this->_configs[$name];
    }

    public function __set($name, $value)
    {
        $this->loadDefault($name);
        self::merge($this->_configs[$name], $value);
    }
    
}