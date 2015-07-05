<?php

use yii\web\View;

//use yii\helpers\Html;

/* @var $this View */
$formatter = Yii::$app->formatter;
?>
<?php if (isset($jadwal)): ?>
    <table width="50%">
        <tbody>
            <?php foreach ($jadwal as $name => $value): ?>
                <tr>
                    <td><?= $name ?></td>
                    <td><?= $formatter->asTime($value) ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
<?php endif; ?>