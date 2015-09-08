<?php
/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \app\models\SignupForm */
?>
<div class="row">
<div class="col-lg-8">
    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title">Sign up</h3>
        </div>
        <div class="box-body">
            <form name="Form" >
                <div class="form-group" ng-class="{'has-error':!!error.username}">
                    <label>Username</label>
                    <input name="username" class="form-control" placeholder="Username"
                           ng-model="model.username">
                    <div class="help-block" ng-bind="error.username"></div>
                </div>
                <div class="form-group" ng-class="{'has-error':!!error.email}">
                    <label>Email</label>
                    <input name="email" class="form-control" placeholder="Email"
                           ng-model="model.email">
                    <div class="help-block" ng-bind="error.email"></div>
                </div>
                <div class="form-group" ng-class="{'has-error':!!error.password}">
                    <label>Password</label>
                    <input name="password" type="password" class="form-control" placeholder="Password"
                           ng-model="model.password" >
                    <div class="help-block" ng-bind="error.password"></div>
                </div>
                <div class="form-group">
                    <button ng-click="submit()" class="btn btn-primary btn-flat">Sign Up</button>
                </div>
            </form>
        </div>
    </div>
</div>
    </div>