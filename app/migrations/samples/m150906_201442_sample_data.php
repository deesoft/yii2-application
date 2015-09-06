<?php

use yii\db\Migration;

class m150906_201442_sample_data extends Migration
{

    protected function toAssoc($array, $fields)
    {
        $result = [];
        foreach ($fields as $i => $field) {
            $result[$field] = $array[$i];
        }
        return $result;
    }

    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        // orgn
        $this->truncateTable('{{%orgn}}');
        $orgn = require __DIR__ . '/orgn.php';
        foreach ($orgn as $row) {
            $this->insert('{{%orgn}}', $this->toAssoc($row, ['id', 'code', 'name']));
        }

        // branch
        $this->truncateTable('{{%branch}}');
        $branch = require __DIR__ . '/branch.php';
        foreach ($branch as $row) {
            $this->insert('{{%branch}}', $this->toAssoc($row, ['id', 'orgn_id', 'code', 'name']));
        }

        // warehouse
        $this->truncateTable('{{%warehouse}}');
        $warehouse = require __DIR__ . '/warehouse.php';
        foreach ($warehouse as $row) {
            $this->insert('{{%warehouse}}', $this->toAssoc($row, ['id', 'branch_id', 'code', 'name']));
        }

        // supplier
        $this->truncateTable('{{%supplier}}');
        $supplier = require __DIR__ . '/supplier.php';
        foreach ($supplier as $row) {
            $this->insert('{{%supplier}}', $this->toAssoc($row, ['id', 'code', 'name']));
        }

        // customer
        $this->truncateTable('{{%customer}}');
        $customer = require __DIR__ . '/customer.php';
        foreach ($customer as $row) {
            $this->insert('{{%customer}}', $this->toAssoc($row, ['id', 'code', 'name']));
        }

        // product category
        $this->truncateTable('{{%category}}');
        $category = require __DIR__ . '/category.php';
        foreach ($category as $row) {
            $this->insert('{{%category}}', $this->toAssoc($row, ['id', 'code', 'name']));
        }

        // product group
        $this->truncateTable('{{%product_group}}');
        $product_group = require __DIR__ . '/product_group.php';
        foreach ($product_group as $row) {
            $this->insert('{{%product_group}}', $this->toAssoc($row, ['id', 'code', 'name']));
        }

        // uom
        $this->truncateTable('{{%uom}}');
        $uom = require __DIR__ . '/uom.php';
        foreach ($uom as $row) {
            $this->insert('{{%uom}}', $this->toAssoc($row, ['id', 'code', 'name']));
        }

        // product
        $this->truncateTable('{{%product}}');
        $this->truncateTable('{{%product_child}}');
        $this->truncateTable('{{%product_uom}}');
        $product = require __DIR__ . '/product.php';
        foreach ($product as $row) {
            $row = $this->toAssoc($row, ['id', 'group_id', 'category_id', 'code', 'name', 'status']);
            $this->insert('{{%product}}', $row);
            // barcode
            for ($i = 0; $i < 3; $i++) {
                $rand = mt_rand(1000000, 9999999) . mt_rand(100000, 999999);
                try {
                    $this->insert('{{%product_child}}', [
                        'barcode' => $rand,
                        'product_id' => $row['id'],
                    ]);
                } catch (Exception $exc) {
                    echo 'Error: ' . $exc->getMessage() . "\n";
                }
            }
            // product uom
            foreach ($uom as $u) {
                $this->insert('{{%product_uom}}', [
                    'product_id' => $row['id'],
                    'uom_id' => $u[0],
                    'isi' => $u[3],
                ]);
            }
        }

        // coa
        $this->truncateTable('{{%coa}}');
        $coa = require __DIR__ . '/coa.php';
        foreach ($coa as $row) {
            $this->insert('{{%coa}}', $this->toAssoc($row, ['id', 'parent_id', 'code', 'name', 'type', 'normal_balance']));
        }
    }

    public function down()
    {
        
    }
}