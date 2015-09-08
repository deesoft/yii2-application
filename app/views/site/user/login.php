<?php

use yii\web\View;

//use yii\helpers\Html;

/* @var $this View */
?>
<div class="login-box-body">
    <p class="login-box-msg">Sign in to start your session</p>
    <form name="Form" >
        <div class="form-group has-feedback" ng-class="{'has-error':!!error.username}">
            <input name="username" class="form-control" placeholder="Username" 
                   ng-model="model.username">
            <span class="glyphicon glyphicon-user form-control-feedback"></span>
            <div class="help-block" ng-bind="error.username"></div>
        </div>
        <div class="form-group has-feedback" ng-class="{'has-error':!!error.password}">
            <input name="password" type="password" class="form-control" placeholder="Password" 
                   ng-model="model.password" >
            <span class="glyphicon glyphicon-lock form-control-feedback"></span>
            <div class="help-block" ng-bind="error.password"></div>
        </div>
        <div class="form-group">
            <button ng-click="login()" class="btn btn-primary btn-flat">Sign In</button>
        </div>
    </form>

    <a href="#/user/forgot-password">I forgot my password</a><br>
    <a href="#/user/signup" class="text-center">Register a new membership</a>
</div>
