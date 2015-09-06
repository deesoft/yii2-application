<?php

use yii\db\Migration;
use yii\helpers\Console;

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

        $command = $this->db->createCommand();
        // orgn
        $this->truncateTable('{{%orgn}}');
        $rows = require __DIR__ . '/orgn.php';
        $total = count($rows);
        echo "insert table {{%orgn}}\n";
        Console::startProgress(0, $total);
        foreach ($rows as $i => $row) {
            $command->insert('{{%orgn}}', $this->toAssoc($row, ['id', 'code', 'name']))->execute();
            Console::updateProgress($i + 1, $total);
        }
        Console::endProgress();

        // branch
        $this->truncateTable('{{%branch}}');
        $rows = require __DIR__ . '/branch.php';
        $total = count($rows);
        echo "insert table {{%branch}}\n";
        Console::startProgress(0, $total);
        foreach ($rows as $i => $row) {
            $command->insert('{{%branch}}', $this->toAssoc($row, ['id', 'orgn_id', 'code', 'name']))->execute();
            Console::updateProgress($i + 1, $total);
        }
        Console::endProgress();

        // warehouse
        $this->truncateTable('{{%warehouse}}');
        $rows = require __DIR__ . '/warehouse.php';
        $total = count($rows);
        echo "insert table {{%warehouse}}\n";
        Console::startProgress(0, $total);
        foreach ($rows as $i => $row) {
            $command->insert('{{%warehouse}}', $this->toAssoc($row, ['id', 'branch_id', 'code', 'name']))->execute();
            Console::updateProgress($i + 1, $total);
        }
        Console::endProgress();

        // supplier
        $this->truncateTable('{{%supplier}}');
        $rows = require __DIR__ . '/supplier.php';
        $total = count($rows);
        echo "insert table {{%supplier}}\n";
        Console::startProgress(0, $total);
        foreach ($rows as $i => $row) {
            $command->insert('{{%supplier}}', $this->toAssoc($row, ['id', 'code', 'name']))->execute();
            Console::updateProgress($i + 1, $total);
        }
        Console::endProgress();

        // customer
        $this->truncateTable('{{%customer}}');
        $rows = require __DIR__ . '/customer.php';
        $total = count($rows);
        echo "insert table {{%customer}}\n";
        Console::startProgress(0, $total);
        foreach ($rows as $i => $row) {
            $command->insert('{{%customer}}', $this->toAssoc($row, ['id', 'code', 'name', 'contact_name',
                    'contact_number', 'status']))->execute();
            Console::updateProgress($i + 1, $total);
        }
        Console::endProgress();

        // product category
        $this->truncateTable('{{%category}}');
        $rows = require __DIR__ . '/category.php';
        $total = count($rows);
        echo "insert table {{%category}}\n";
        Console::startProgress(0, $total);
        foreach ($rows as $i => $row) {
            $command->insert('{{%category}}', $this->toAssoc($row, ['id', 'code', 'name']))->execute();
            Console::updateProgress($i + 1, $total);
        }
        Console::endProgress();

        // product group
        $this->truncateTable('{{%product_group}}');
        $rows = require __DIR__ . '/product_group.php';
        $total = count($rows);
        echo "insert table {{%product_group}}\n";
        Console::startProgress(0, $total);
        foreach ($rows as $i => $row) {
            $command->insert('{{%product_group}}', $this->toAssoc($row, ['id', 'code', 'name']))->execute();
            Console::updateProgress($i + 1, $total);
        }
        Console::endProgress();

        // product
        $this->truncateTable('{{%product_child}}');
        $this->truncateTable('{{%product}}');
        $rows = require __DIR__ . '/product.php';
        $total = count($rows);
        echo "insert table {{%product}}\n";
        Console::startProgress(0, $total);
        foreach ($rows as $i => $row) {
            $row = $this->toAssoc($row, ['id', 'group_id', 'category_id', 'code', 'name', 'status']);
            $command->insert('{{%product}}', $row)->execute();
            // barcode
            $batch = [];
            for ($j = 0; $j < 3; $j++) {
                $rand = mt_rand(1000000, 9999999) . mt_rand(100000, 999999);
                $batch[] = [$rand, $row['id']];
            }
            try {
                $command->batchInsert('{{%product_child}}', ['barcode', 'product_id'], $batch)->execute();
            } catch (Exception $exc) {
                echo 'Error: ' . $exc->getMessage() . "\n";
            }
            Console::updateProgress($i + 1, $total);
        }
        Console::endProgress();

        // uom
        $this->truncateTable('{{%product_uom}}');
        $this->truncateTable('{{%uom}}');
        $rows = require __DIR__ . '/uom.php';
        $total = count($rows);
        echo "insert table {{%uom}}\n";
        Console::startProgress(0, $total);
        foreach ($rows as $i => $row) {
            $command->insert('{{%uom}}', $this->toAssoc($row, ['id', 'code', 'name']))->execute();

            // product uom
            $sql = "insert into {{%product_uom}}([[product_id]],[[uom_id]],[[isi]])\n"
                . "select [[id]],{$row[0]},{$row[3]} from {{%product}}";
            $command->setSql($sql)->execute();
            Console::updateProgress($i + 1, $total);
        }
        Console::endProgress();

        // coa
        $this->truncateTable('{{%coa}}');
        $rows = require __DIR__ . '/coa.php';
        $total = count($rows);
        echo "insert table {{%coa}}\n";
        Console::startProgress(0, $total);
        foreach ($rows as $i => $row) {
            $command->insert('{{%coa}}', $this->toAssoc($row, ['id', 'parent_id', 'code',
                    'name', 'type', 'normal_balance']))->execute();
            Console::updateProgress($i + 1, $total);
        }
        Console::endProgress();
    }

    public function down()
    {
        
    }
}