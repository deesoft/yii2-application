<?php

use yii\web\View;

//use yii\helpers\Html;

/* @var $this View */
?>
<?php
$format = 'Y-m-d';
$value = '14-09-13';

$hasTimeInfo = (strpbrk($format, 'HhGgis') !== false);
$date = DateTime::createFromFormat($format, $value, new DateTimeZone($hasTimeInfo ? $this->timeZone : 'UTC'));
$errors = DateTime::getLastErrors();
if ($date === false || $errors['error_count'] || $errors['warning_count']) {
    echo 'false';
    print_r($error);
    return;
}

if (!$hasTimeInfo) {
    $date->setTime(0, 0, 0);
}
echo $date->getTimestamp();