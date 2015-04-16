<?php

namespace app\components;

use yii\base\UnknownPropertyException;
use yii\base\UnknownMethodException;

/**
 * Prototype
 *
 * ~~~
 * Yii::$app->attachBehavior(0,Prototype::className());
 *
 * Yii::$app->prototype->x = 1;
 * echo Yii::$app->x; // 1
 * Yii::$app->x = 'seratus';
 * echo Yii::$app->x; // 'seratus'
 *
 * Yii::$app->prototype->z = function($var){
 *    echo $var;
 * }
 *
 * Yii::$app->z();
 * ~~~
 *
 * @author Misbahul D Munir <misbahuldmunir@gmail.com>
 * @since 1.0
 */
class Prototype extends \yii\base\Behavior
{
    const REF_NAME = 'prototype';

    /**
     * @var array
     */
    private $_fn = [];

    /**
     * @inheritdoc
     */
    public function canGetProperty($name, $checkVars = true)
    {
        return $name === static::REF_NAME || array_key_exists($name, $this->_fn) || $this->hasMethod('get'.ucfirst($name));
    }

    /**
     * @inheritdoc
     */
    public function __get($name)
    {
        if ($name === static::REF_NAME) {
            return $this;
        } elseif (array_key_exists($name, $this->_fn)) {
            return $this->_fn[$name];
        } elseif ($this->hasMethod('get'.ucfirst($name))) {
            return call_user_func($this->_fn['get'.ucfirst($name)]);
        } else {
            throw new UnknownPropertyException('Getting unknown property: '.get_class($this).'::'.$name);
        }
    }

    /**
     * @inheritdoc
     */
    public function canSetProperty($name, $checkVars = true)
    {
        return array_key_exists($name, $this->_fn);
    }

    /**
     * @inheritdoc
     */
    public function __set($name, $value)
    {
        $this->_fn[$name] = $value;
    }

    /**
     * @inheritdoc
     */
    public function __unset($name)
    {
        if (array_key_exists($name, $this->_fn)) {
            unset($this->_fn[$name]);
        }
    }

    /**
     * @inheritdoc
     */
    public function hasMethod($name)
    {
        return isset($this->_fn[$name]) && is_callable($this->_fn[$name]);
    }

    /**
     * @inheritdoc
     */
    public function __call($name, $params)
    {
//        array_unshift($params, $this->owner);
        if ($this->hasMethod($name)) {
            return call_user_func_array($this->_fn[$name], $params);
        }
        throw new UnknownMethodException('Calling unknown method: '.get_class($this)."::$name()");
    }
}