<?php
/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \app\models\SignupForm */
?>
<div class="box box-primary">
    <div class="box-header with-border">
        <h3 class="box-title">Sign up</h3>
    </div>
    <div class="box-body">
        <form name="Form" >
            <div class="form-group has-feedback" >
                <input name="username" class="form-control" placeholder="Username"
                       ng-model="model.username">
                <span class="glyphicon glyphicon-user form-control-feedback"></span>
                <div class="help-block" ng-bind="error.username"></div>
            </div>
            <div class="form-group has-feedback" >
                <input name="email" class="form-control" placeholder="Email"
                       ng-model="model.email">
                <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
                <div class="help-block" ng-bind="error.email"></div>
            </div>
            <div class="form-group has-feedback">
                <input name="password" type="password" class="form-control" placeholder="Password"
                       ng-model="model.password" >
                <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                <div class="help-block" ng-bind="error.password"></div>
            </div>
            <div class="form-group">
                <button ng-click="submit()" class="btn btn-primary btn-flat">Sign Up</button>
            </div>
        </form>
    </div>
</div>
