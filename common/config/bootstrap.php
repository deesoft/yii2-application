<?php
Yii::setAlias('common', dirname(__DIR__));
Yii::setAlias('app', dirname(dirname(__DIR__)) . '/app');
Yii::setAlias('rest', dirname(dirname(__DIR__)) . '/rest');
\dee\rest\Bootstrap::apply();