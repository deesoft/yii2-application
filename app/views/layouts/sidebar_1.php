<?php

use app\components\SideMenu;
use mdm\admin\components\MenuHelper;

/* @var $this yii\web\View */
?>
<section class="sidebar">
    <!-- Sidebar user panel -->
    <div class="user-panel">
        <div class="pull-left image">
            <img src="<?= $baseurl ?>/img/avatar04.png" class="img-circle" alt="User Image" />
        </div>
        <div class="pull-left info">
            <p>Hello, <?php echo (!Yii::$app->user->isGuest) ? Yii::$app->user->identity->username : 'Guest'; ?></p>
            <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
        </div>
    </div>
    <!-- sidebar menu: : style can be found in sidebar.less -->
    <?php
//    $items = [
//        ['label' => 'Dashboard', 'url' => ['/site/index'], 'icon' => 'fa fa-dashboard'],
//        ['label' => 'Admin Manager', 'icon' => 'fa fa-wrench',
//            'items' => [
//                ['label' => 'Users', 'url' => ['/site/user-list'], 'icon' => 'fa fa-angle-double-right'],
//                ['label' => 'Access Control', 'icon' => 'fa fa-angle-double-right'],
//            ]],
//        ['label' => 'Master', 'icon' => 'fa fa-gears',
//            'items' => [
//                ['label' => 'Organizaion', 'url' => ['/master/orgn/index'], 'icon' => 'fa fa-angle-double-right'],
//                ['label' => 'Branch', 'url' => ['/master/branch/index'], 'icon' => 'fa fa-angle-double-right'],
//                ['label' => 'User2Branch', 'url' => ['/master/user-to-branch'], 'icon' => 'fa fa-angle-double-right'],
//                ['label' => 'Warehouse', 'url' => ['/master/warehouse'], 'icon' => 'fa fa-angle-double-right'],
//                ['label' => 'Product', 'url' => ['/master/product'], 'icon' => 'fa fa-angle-double-right'],
//                ['label' => 'Customer', 'url' => ['/master/customer'], 'icon' => 'fa fa-angle-double-right'],
//                ['label' => 'Supplier', 'url' => ['/master/supplier'], 'icon' => 'fa fa-angle-double-right'],
//            ]],
//        ['label' => 'Purchase', 'icon' => 'fa fa-shopping-cart',
//            'items' => [
//                ['label' => 'Purchase Order', 'url' => ['/purchase/purchase/index'], 'icon' => 'fa fa-angle-double-right'],
//                ['label' => 'Product Pricing', 'url' => ['/purchase/purchase'], 'icon' => 'fa fa-angle-double-right'],
//                ['label' => 'Cogs Management', 'icon' => 'fa fa-angle-double-right'],
//            ]],
//        ['label' => 'Inventory', 'url' => ['#'], 'icon' => 'fa fa-th-large',
//            'items' => [
//                ['label' => 'Transfer', 'url' => ['/inventory/transfer'], 'icon' => 'fa fa-angle-double-right'],
//                ['label' => 'Receive', 'url' => ['/inventory/receive'], 'icon' => 'fa fa-angle-double-right'],
//                ['label' => 'Transfer Notes', 'url' => ['/inventory/notice'], 'icon' => 'fa fa-angle-double-right'],
//                ['label' => 'Product Stock', 'url' => ['/master/product-stock'], 'icon' => 'fa fa-angle-double-right'],
//                ['label' => 'Stock Opname', 'url' => '#', 'icon' => 'fa fa-angle-double-right'],
//                ['label' => 'Stock Adjustment', 'url' => '#', 'icon' => 'fa fa-angle-double-right'],
//                ['label' => 'Stock Movement History', 'url' => ['/inventory/log-stock'], 'icon' => 'fa fa-angle-double-right'],
//                ['label' => 'Material Transfer', 'url' => '#', 'icon' => 'fa fa-angle-double-right'],
//            ]],
//        ['label' => 'Sales', 'url' => ['#'], 'icon' => 'fa fa-barcode',
//            'items' => [
//                ['label' => 'Retail-POS', 'url' => ['/sales/pos/create'], 'icon' => 'fa fa-angle-double-right'],
//                ['label' => 'Penjualan Grosir', 'url' => ['/sales/standart/create'], 'icon' => 'fa fa-angle-double-right'],
//                ['label' => 'Retur Penjualan', 'url' => ['#'], 'icon' => 'fa fa-angle-double-right'],
//                ['label' => 'Cashdrawer', 'url' => ['/sales/drawer'], 'icon' => 'fa fa-angle-double-right'],
//            ]],
//        ['label' => 'Accounting', 'url' => ['#'], 'icon' => 'fa fa-money',
//            'items' => [
//                ['label' => 'Periode', 'url' => ['/accounting/acc-periode'], 'icon' => 'fa fa-angle-double-right'],
//                ['label' => 'COA', 'url' => ['/accounting/coa'], 'icon' => 'fa fa-angle-double-right'],
//                ['label' => 'Entri-Sheet', 'url' => ['/accounting/entri-sheet'], 'icon' => 'fa fa-angle-double-right'],
//                ['label' => 'GL Entri  (by Entri-Sheet)', 'url' => ['/accounting/gl-entri-sheet/create'], 'icon' => 'fa fa-angle-double-right'],
//                ['label' => 'GL Detail', 'url' => ['/accounting/entri-gl'], 'icon' => 'fa fa-angle-double-right'],
//                ['label' => 'Cash In', 'url' => ['/accounting/about'], 'icon' => 'fa fa-angle-double-right'],
//                ['label' => 'Cash Out', 'url' => ['#'], 'icon' => 'fa fa-angle-double-right'],
//                ['label' => 'Bank In', 'url' => ['/accounting/about'], 'icon' => 'fa fa-angle-double-right'],
//                ['label' => 'Bank Out', 'url' => ['/accounting/about'], 'icon' => 'fa fa-angle-double-right'],
//            ]],
//        ['label' => 'Reports', 'url' => ['#'], 'icon' => 'fa fa-files-o',
//            'items' => [
//                ['label' => 'test', 'icon' => 'fa fa-angle-double-right'],
//                ['label' => 'test2', 'icon' => 'fa fa-angle-double-right'],
//                ['label' => 'test3', 'icon' => 'fa fa-angle-double-right'],
//            ]],
//    ];

    $menuCallback = function($menu) {
        $item = [
            'label' => $menu['name'],
            'url' => MenuHelper::parseRoute($menu['route']),
        ];
        if (!empty($menu['data'])) {
            $item['icon'] = 'fa ' . $menu['data'];
        } else {
            $item['icon'] = 'fa fa-angle-double-right';
        }
        if ($menu['children'] != []) {
            $item['items'] = $menu['children'];
        }
        return $item;
    };

    $items = MenuHelper::getAssignedMenu(Yii::$app->user->id, null, $menuCallback);
    //$items = [];
    echo SideMenu::widget([
        'items' => $items,
    ]);
    ?>

</section>
<!-- /.sidebar -->
