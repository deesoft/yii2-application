<?php

namespace app\api;

use Yii;

/**
 * Description of Bootstrap
 *
 * @author Misbahul D Munir <misbahuldmunir@gmail.com>
 * @since 1.0
 */
class Bootstrap implements \yii\base\BootstrapInterface
{
    public function bootstrap($app)
    {
        $definitions = require(__DIR__ . '/definitions.php');
        foreach ($definitions as $name => $definition) {
            Yii::$container->set($name, $definition);
        }

        $hooks = require(__DIR__ . '/hooks.php');
        $app->attachBehaviors(array_combine($hooks, $hooks));
    }

}