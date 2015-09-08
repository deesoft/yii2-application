<?php
return[
    ['label' => 'Home', 'url' => '#/index'],
    ['label' => 'Sign up', 'url' => '#/user/signup'],
    ['label' => 'Purchase', 'url'=>'#/purchase',
        'items' => [
            ['label' => 'New', 'url' => '#/purchase/new']
        ],
    ],
    ['label' => 'Product', 'url'=>'#/product',
        'items' => [
            ['label' => 'New', 'url' => '#/product/new']
        ],
    ],
];
