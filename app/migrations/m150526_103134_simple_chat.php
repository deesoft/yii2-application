<?php

use yii\db\Schema;
use yii\db\Migration;

class m150526_103134_simple_chat extends Migration
{

    public function safeUp()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%chat_account}}', [
            'id' => Schema::TYPE_PK,
            'name' => Schema::TYPE_STRING . '(32) NOT NULL',
            'last_actifity' => Schema::TYPE_INTEGER,
            ], $tableOptions);

        $this->createTable('{{%chat}}', [
            'id' => Schema::TYPE_PK,
            'time' => Schema::TYPE_INTEGER,
            'from' => Schema::TYPE_INTEGER,
            'to' => Schema::TYPE_INTEGER,
            'message' => Schema::TYPE_STRING . '(128)',
            'read' => Schema::TYPE_INTEGER . ' NOT NULL DEFAULT 0',
            ], $tableOptions);
    }

    public function safeDown()
    {
        $this->dropTable('{{%chat}}');
        $this->dropTable('{{%chat_account}}');
    }
    /*
      // Use safeUp/safeDown to run migration code within a transaction
      public function safeUp()
      {
      }

      public function safeDown()
      {
      }
     */
}