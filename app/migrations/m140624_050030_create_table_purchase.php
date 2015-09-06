<?php

use yii\db\Schema;

/**
 * 
 * @author Misbahul D Munir <misbahuldmunir@gmail.com>  
 * @since 3.0
 */
class m140624_050030_create_table_purchase extends \yii\db\Migration
{

    public function safeUp()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%purchase}}', [
            'id' => Schema::TYPE_PK,
            'number' => Schema::TYPE_STRING . '(16) NOT NULL',
            'supplier_id' => Schema::TYPE_INTEGER . ' NOT NULL',
            'branch_id' => Schema::TYPE_INTEGER . ' NOT NULL',
            'date' => Schema::TYPE_DATE . ' NOT NULL',
            'value' => Schema::TYPE_FLOAT . ' NOT NULL',
            'discount' => Schema::TYPE_FLOAT,
            'status' => Schema::TYPE_INTEGER . ' NOT NULL',
            // history column
            'created_at' => Schema::TYPE_INTEGER,
            'created_by' => Schema::TYPE_INTEGER,
            'updated_at' => Schema::TYPE_INTEGER,
            'updated_by' => Schema::TYPE_INTEGER,
            ], $tableOptions);

        $this->createTable('{{%purchase_dtl}}', [
            'purchase_id' => Schema::TYPE_INTEGER . ' NOT NULL',
            'product_id' => Schema::TYPE_INTEGER . ' NOT NULL',
            'uom_id' => Schema::TYPE_INTEGER . ' NOT NULL',
            'qty' => Schema::TYPE_FLOAT . ' NOT NULL',
            'price' => Schema::TYPE_FLOAT . ' NOT NULL',
            'discount' => Schema::TYPE_FLOAT,
            'total_receive' => Schema::TYPE_FLOAT,
            // constrain
            'PRIMARY KEY ([[purchase_id]], [[product_id]])',
            'FOREIGN KEY ([[purchase_id]]) REFERENCES {{%purchase}} ([[id]]) ON DELETE CASCADE ON UPDATE CASCADE',
            ], $tableOptions);
    }

    public function safeDown()
    {
        $this->dropTable('{{%purchase_dtl}}');
        $this->dropTable('{{%purchase}}');
    }
}