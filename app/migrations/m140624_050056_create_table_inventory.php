<?php

use yii\db\Schema;

/**
 * 
 * @author Misbahul D Munir <misbahuldmunir@gmail.com>  
 * @since 3.0
 */
class m140624_050056_create_table_inventory extends \yii\db\Migration
{

    public function safeUp()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%transfer}}', [
            'id' => Schema::TYPE_PK,
            'number' => Schema::TYPE_STRING . '(16) NOT NULL',
            'branch_id' => Schema::TYPE_INTEGER . ' NOT NULL',
            'branch_dest_id' => Schema::TYPE_INTEGER . ' NOT NULL',
            'date' => Schema::TYPE_DATE . ' NOT NULL',
            'status' => Schema::TYPE_INTEGER . ' NOT NULL',
            // history column
            'created_at' => Schema::TYPE_INTEGER,
            'created_by' => Schema::TYPE_INTEGER,
            'updated_at' => Schema::TYPE_INTEGER,
            'updated_by' => Schema::TYPE_INTEGER,
            ], $tableOptions);

        $this->createTable('{{%transfer_dtl}}', [
            'transfer_id' => Schema::TYPE_INTEGER . ' NOT NULL',
            'product_id' => Schema::TYPE_INTEGER . ' NOT NULL',
            'uom_id' => Schema::TYPE_INTEGER . ' NOT NULL',
            'qty' => Schema::TYPE_FLOAT,
            'total_release' => Schema::TYPE_FLOAT,
            'total_receive' => Schema::TYPE_FLOAT,
            // constrain
            'PRIMARY KEY ([[transfer_id]], [[product_id]])',
            'FOREIGN KEY ([[transfer_id]]) REFERENCES {{%transfer}} ([[id]]) ON DELETE CASCADE ON UPDATE CASCADE',
            ], $tableOptions);

        $this->createTable('{{%stock_opname}}', [
            'id' => Schema::TYPE_PK,
            'number' => Schema::TYPE_STRING . '(16) NOT NULL',
            'warehouse_id' => Schema::TYPE_INTEGER . ' NOT NULL',
            'date' => Schema::TYPE_DATE . ' NOT NULL',
            'status' => Schema::TYPE_INTEGER . ' NOT NULL',
            'description' => Schema::TYPE_STRING,
            'operator' => Schema::TYPE_STRING,
            // history column
            'created_at' => Schema::TYPE_INTEGER,
            'created_by' => Schema::TYPE_INTEGER,
            'updated_at' => Schema::TYPE_INTEGER,
            'updated_by' => Schema::TYPE_INTEGER,
            ], $tableOptions);

        $this->createTable('{{%stock_opname_dtl}}', [
            'opname_id' => Schema::TYPE_INTEGER . ' NOT NULL',
            'product_id' => Schema::TYPE_INTEGER . ' NOT NULL',
            'uom_id' => Schema::TYPE_INTEGER . ' NOT NULL',
            'qty' => Schema::TYPE_FLOAT . ' NOT NULL',
            // constrain
            'PRIMARY KEY ([[opname_id]] , [[product_id]])',
            'FOREIGN KEY ([[opname_id]]) REFERENCES {{%stock_opname}} ([[id]]) ON DELETE CASCADE ON UPDATE CASCADE',
            ], $tableOptions);

        $this->createTable('{{%stock_adjustment}}', [
            'id' => Schema::TYPE_PK,
            'number' => Schema::TYPE_STRING . '(16) NOT NULL',
            'warehouse_id' => Schema::TYPE_INTEGER . ' NOT NULL',
            'date' => Schema::TYPE_DATE . ' NOT NULL',
            'reff_id' => Schema::TYPE_INTEGER,
            'description' => Schema::TYPE_STRING,
            'status' => Schema::TYPE_INTEGER . ' NOT NULL',
            // history column
            'created_at' => Schema::TYPE_INTEGER,
            'created_by' => Schema::TYPE_INTEGER,
            'updated_at' => Schema::TYPE_INTEGER,
            'updated_by' => Schema::TYPE_INTEGER,
            ], $tableOptions);

        $this->createTable('{{%stock_adjustment_dtl}}', [
            'adjustment_id' => Schema::TYPE_INTEGER . ' NOT NULL',
            'product_id' => Schema::TYPE_INTEGER . ' NOT NULL',
            'uom_id' => Schema::TYPE_INTEGER . ' NOT NULL',
            'qty' => Schema::TYPE_FLOAT . ' NOT NULL',
            'item_value' => Schema::TYPE_FLOAT . ' NOT NULL',
            // constrain
            'PRIMARY KEY ([[adjustment_id]], [[product_id]])',
            'FOREIGN KEY ([[adjustment_id]]) REFERENCES {{%stock_adjustment}} ([[id]]) ON DELETE CASCADE ON UPDATE CASCADE',
            ], $tableOptions);

        $this->createTable('{{%goods_movement}}', [
            'id' => Schema::TYPE_PK,
            'number' => Schema::TYPE_STRING . '(16) NOT NULL',
            'warehouse_id' => Schema::TYPE_INTEGER . ' NOT NULL',
            'date' => Schema::TYPE_DATE . ' NOT NULL',
            'type' => Schema::TYPE_INTEGER . ' NOT NULL',
            'reff_type' => Schema::TYPE_INTEGER,
            'reff_id' => Schema::TYPE_INTEGER,
            'description' => Schema::TYPE_STRING,
            'status' => Schema::TYPE_INTEGER . ' NOT NULL',
            'trans_value' => Schema::TYPE_FLOAT,
            'total_invoiced' => Schema::TYPE_FLOAT,
            // history column
            'created_at' => Schema::TYPE_INTEGER,
            'created_by' => Schema::TYPE_INTEGER,
            'updated_at' => Schema::TYPE_INTEGER,
            'updated_by' => Schema::TYPE_INTEGER,
            ], $tableOptions);

        $this->createTable('{{%goods_movement_dtl}}', [
            'movement_id' => Schema::TYPE_INTEGER . ' NOT NULL',
            'product_id' => Schema::TYPE_INTEGER . ' NOT NULL',
            'uom_id' => Schema::TYPE_INTEGER . ' NOT NULL',
            'qty' => Schema::TYPE_FLOAT . ' NOT NULL',
            'item_value' => Schema::TYPE_FLOAT,
            'trans_value' => Schema::TYPE_FLOAT,
            // constrain
            'PRIMARY KEY ([[movement_id]], [[product_id]])',
            'FOREIGN KEY ([[movement_id]]) REFERENCES {{%goods_movement}} ([[id]]) ON DELETE CASCADE ON UPDATE CASCADE',
            ], $tableOptions);

        $this->createTable('{{%product_stock_history}}', [
            'time' => Schema::TYPE_INTEGER,
            'warehouse_id' => Schema::TYPE_INTEGER . ' NOT NULL',
            'product_id' => Schema::TYPE_INTEGER . ' NOT NULL',
            'qty' => Schema::TYPE_FLOAT . ' NOT NULL',
            // constrain
            'PRIMARY KEY ([[time]], [[warehouse_id]], [[product_id]])',
            ], $tableOptions);
    }

    public function safeDown()
    {
        $this->dropTable('{{%product_stock_history}}');

        $this->dropTable('{{%goods_movement_dtl}}');
        $this->dropTable('{{%goods_movement}}');

        $this->dropTable('{{%stock_adjustment_dtl}}');
        $this->dropTable('{{%stock_adjustment}}');

        $this->dropTable('{{%stock_opname_dtl}}');
        $this->dropTable('{{%stock_opname}}');

        $this->dropTable('{{%transfer_dtl}}');
        $this->dropTable('{{%transfer}}');
    }
}