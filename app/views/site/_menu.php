<?php
return[
    ['label' => 'Home', 'url' => '#/index'],
    ['label' => 'Sign up', 'url' => '#/user/signup'],
    ['label' => 'Purchase', 'url'=>true,
        'items' => [
            ['label' => 'List', 'url' => '#/purchase'],
            ['label' => 'New', 'url' => '#/purchase/new']
        ]
    ]
];
