<?php

use yii\db\Schema;

/**
 * 
 * @author Misbahul D Munir <misbahuldmunir@gmail.com>  
 * @since 3.0
 */
class m140624_050114_create_table_sales extends \yii\db\Migration
{

    public function safeUp()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%sales}}', [
            'id' => Schema::TYPE_PK,
            'number' => Schema::TYPE_STRING . '(16) NOT NULL',
            'branch_id' => Schema::TYPE_INTEGER . ' NOT NULL',
            'customer_id' => Schema::TYPE_INTEGER,
            'date' => Schema::TYPE_DATE . ' NOT NULL',
            'value' => Schema::TYPE_FLOAT . ' NOT NULL',
            'discount' => Schema::TYPE_FLOAT . ' NULL',
            'status' => Schema::TYPE_INTEGER . ' NOT NULL',
            // history column
            'created_at' => Schema::TYPE_INTEGER,
            'created_by' => Schema::TYPE_INTEGER,
            'updated_at' => Schema::TYPE_INTEGER,
            'updated_by' => Schema::TYPE_INTEGER,
            // constrain
            ], $tableOptions);

        $this->createTable('{{%sales_dtl}}', [
            'sales_id' => Schema::TYPE_INTEGER . ' NOT NULL',
            'product_id' => Schema::TYPE_INTEGER . ' NOT NULL',
            'uom_id' => Schema::TYPE_INTEGER . ' NOT NULL',
            'qty' => Schema::TYPE_FLOAT . ' NOT NULL',
            'price' => Schema::TYPE_FLOAT . ' NOT NULL',
            'qty_release' => Schema::TYPE_FLOAT,
            'cogs' => Schema::TYPE_FLOAT . ' NOT NULL',
            'discount' => Schema::TYPE_FLOAT,
            'tax' => Schema::TYPE_FLOAT,
            // constrain
            'PRIMARY KEY ([[sales_id]], [[product_id]])',
            'FOREIGN KEY ([[sales_id]]) REFERENCES {{%sales}} ([[id]]) ON DELETE CASCADE ON UPDATE CASCADE',
            ], $tableOptions);
    }

    public function safeDown()
    {
        $this->dropTable('{{%sales_dtl}}');
        $this->dropTable('{{%sales}}');
    }
}