<?php
use yii\web\View;

/* @var $this View*/

$this->title = 'Simple Chat';
$this->registerJs($this->render('script.js.php'));
?>
<style>
    #list-account li.idle a{
        color: gray;
    }
    #list-account li.online a{
        color: black;
    }
    #list-account li.active{
        background: #ddd;
    }
    #list-account li.new-message a::after{
        content: " (new)";
        color: red;
    }
    #messages div.sent{
        text-align: right;
    }
    #messages div.receive{
        text-align: left;
    }
    #messages {
        overflow: auto;
        height: 300px;
        padding: 20px;
    }
    #messages div{
        padding-bottom: 10px;
    }
</style>
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