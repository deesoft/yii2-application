<?php

namespace app\commands;

use yii\helpers\StringHelper;

/**
 * Description of TestController
 *
 * @author Misbahul D Munir <misbahuldmunir@gmail.com>
 * @since 1.0
 */
class TestController extends \yii\console\Controller
{
    public function actionIndex()
    {
        if(StringHelper::endsWith('bio1998B2.png', '.png', false )){
            echo "True\n";
        }  else {
            echo "False\n";
        }
    }
}