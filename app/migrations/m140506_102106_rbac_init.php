<?php

/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */
use yii\di\Instance;
use yii\db\Connection;
use yii\helpers\ArrayHelper;

/**
 * Initializes RBAC tables
 *
 * @author Alexander Kochetov <creocoder@gmail.com>
 * @since 2.0
 */
class m140506_102106_rbac_init extends \yii\db\Migration
{
    protected $configs = [
        'itemTable' => '{{%auth_item}}',
        'itemChildTable' => '{{%auth_item_child}}',
        'assignmentTable' => '{{%auth_assignment}}',
        'ruleTable' => '{{%auth_rule}}',
        'db' => 'db'
    ];

    public function up()
    {
        $configs = array_merge($this->configs, ArrayHelper::getValue(Yii::$app->params, 'migration.rbac', []));
        $this->db = Instance::ensure($configs['db'], Connection::className());

        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable($configs['ruleTable'], [
            'name' => $this->string(64)->notNull(),
            'data' => $this->text(),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
            'PRIMARY KEY (name)',
            ], $tableOptions);

        $this->createTable($configs['itemTable'], [
            'name' => $this->string(64)->notNull(),
            'type' => $this->integer()->notNull(),
            'description' => $this->text(),
            'rule_name' => $this->string(64),
            'data' => $this->text(),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
            'PRIMARY KEY (name)',
            'FOREIGN KEY (rule_name) REFERENCES ' . $configs['ruleTable'] . ' (name) ON DELETE SET NULL ON UPDATE CASCADE',
            ], $tableOptions);
        $this->createIndex('idx-auth_item-type', $configs['itemTable'], 'type');

        $this->createTable($configs['itemChildTable'], [
            'parent' => $this->string(64)->notNull(),
            'child' => $this->string(64)->notNull(),
            'PRIMARY KEY (parent, child)',
            'FOREIGN KEY (parent) REFERENCES ' . $configs['itemTable'] . ' (name) ON DELETE CASCADE ON UPDATE CASCADE',
            'FOREIGN KEY (child) REFERENCES ' . $configs['itemTable'] . ' (name) ON DELETE CASCADE ON UPDATE CASCADE',
            ], $tableOptions);

        $this->createTable($configs['assignmentTable'], [
            'item_name' => $this->string(64)->notNull(),
            'user_id' => $this->string(64)->notNull(),
            'created_at' => $this->integer(),
            'PRIMARY KEY (item_name, user_id)',
            'FOREIGN KEY (item_name) REFERENCES ' . $configs['itemTable'] . ' (name) ON DELETE CASCADE ON UPDATE CASCADE',
            ], $tableOptions);
    }

    public function down()
    {
        $configs = array_merge($this->configs, ArrayHelper::getValue(Yii::$app->params, 'migration.rbac', []));
        $this->db = Instance::ensure($configs['db'], Connection::className());

        $this->dropTable($configs['assignmentTable']);
        $this->dropTable($configs['itemChildTable']);
        $this->dropTable($configs['itemTable']);
        $this->dropTable($configs['ruleTable']);
    }
}