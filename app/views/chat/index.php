<?php

use yii\web\View;
use yii\helpers\Url;

/* @var $this View */

$this->title = 'Simple Chat';
$this->registerJs($this->render('script.js'), View::POS_END);
$this->registerCss($this->render('style.css'));

$urls = [
    'chatUrl' => Url::to(['chat']),
    'newAccountUrl' => Url::to(['new-account']),
    'markReadUrl' => Url::to(['mark-read']),
];

$this->registerJs('yii.dChat.initProperty(' . json_encode($urls) . ')');
?>

<p>
    Source code: <a href="https://github.com/deesoft/yii2-application/tree/master/app" target="_blank">Github</a>
</p>
<div class="row">
    <div class="col-lg-4">
        <div>
            Nama:<br>
            <input type="text" id="inp-account"  class="col-lg-12">
            <div id="my-info" style="display:none;">
                <strong id="my-name"></strong><br>
                <a href="javascript:;" class="btn btn-danger btn-sm" id="btn-close">Close</a>
            </div>
        </div>
        <div>
            <br>
            <ul id="list-account"></ul>
        </div>
    </div>
    <div class="col-lg-4">
        <div id="messages"></div>
        <div>
            <input type="text" id="inp-chat" class="col-lg-12">
        </div>
    </div>
</div>