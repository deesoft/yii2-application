<?php
/* @var $this yii\web\View */

?>
<div class="box box-info">
    <div class="box-header with-border">
        <page title="Contact"></page>
        <h3 class="box-title">Contact</h3>
    </div>
    <div class="box-body">
        <form name="Form" >
            <div class="form-group has-feedback" ng-class="{'has-error':!!error.name}">
                <input name="name" class="form-control" placeholder="Full name"
                       ng-model="model.name">
                <span class="glyphicon glyphicon-user form-control-feedback"></span>
                <div class="help-block" ng-bind="error.name"></div>
            </div>
            <div class="form-group has-feedback" ng-class="{'has-error':!!error.name}">
                <input name="email" class="form-control" placeholder="Email"
                       ng-model="model.email">
                <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
                <div class="help-block" ng-bind="error.name"></div>
            </div>
            <div class="form-group has-feedback" ng-class="{'has-error':!!error.name}">
                <input name="subject" class="form-control" placeholder="Subject"
                       ng-model="model.subject">
                <span class="glyphicon glyphicon-user form-control-feedback"></span>
                <div class="help-block" ng-bind="error.subject"></div>
            </div>
            <div class="form-group" ng-class="{'has-error':!!error.body}">
                <textarea name="body" class="form-control" placeholder="Enter"
                          ng-model="model.body" rows="10"></textarea>
                <div class="help-block" ng-bind="error.body"></div>
            </div>
            <div class="form-group">
                <button ng-click="submit()" class="btn btn-primary btn-flat">Send</button>
            </div>
        </form>
    </div>
</div>
