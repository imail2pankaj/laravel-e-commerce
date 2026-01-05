<?php

return [
    [
        'title' => 'Dashboard',
        'icon'  => 'menu-icon icon-base ti tabler-smart-home',
        'route' => 'admin.users.dashboard',
     
    ],

    [
        'title' => 'Admin Management',
        'icon'  => 'menu-icon icon-base ti tabler-users',
        'permission' => 'admins.view',
        'children' => [
            ['title' => 'Admins', 'route' => 'admin.users.index' ],
            ['title' => 'Roles', 'route' => 'admin.roles.index'],
            ['title' => 'Permission', 'route' => 'role.permissions.edit'],
        ]
    ],

    [
        'title' => 'Category Management',
        'icon'  => 'menu-icon icon-base ti tabler-list-check',
        'permission' => 'categories.view',
        'children' => [
            ['title' => 'Category', 'route' => 'admin.categories.index'],
            ['title' => 'Add Category', 'route' => 'admin.categories.create', 'permission' => 'categories.create'],
               
        ]
    ],

    [
        'title' => 'Brand Management',
        'icon'  => 'menu-icon icon-base ti tabler-brand-asana',
        'permission' => 'brands.view',
        'children' => [
            ['title' => 'Brand', 'route' => 'admin.brands.index'],
            ['title' => 'Add Brand', 'route' => 'admin.brands.create'],
               
        ]
    ],

    [
        'title' => 'Attribute Management',
        'icon'  => 'menu-icon icon-base ti tabler-settings-share',
        'permission' => 'attributes.view',
        'children' => [
            ['title' => 'Attribute', 'route' => 'admin.attributes.index'],
            ['title' => 'Values', 'route' => 'attributeValue.list'],
               
        ]
    ],

    [
        'title' => 'Product Management',
        'icon'  => 'menu-icon icon-base ti tabler-brand-producthunt',
        'permission' => 'products.view',
        'children' => [
            ['title' => 'Product', 'route' => 'product.list'],
            ['title' => 'Inventory', 'route' => 'product.variants.list'],
        ]
    ],

    [
        'title' => 'Coupon Management',
        'icon'  => 'menu-icon icon-base ti tabler-ticket',
        'permission' => 'coupons.view',
        'children' => [
            ['title' => 'Coupons', 'route' => 'admin.coupons.index'],
            ['title' => 'Add Coupon', 'route' => 'admin.coupons.create'],
        ]
    ],

    [
        'title' => 'Customer Management',
        'icon'  => 'menu-icon icon-base ti tabler-user-circle',
        'permission' => 'customers.view',
        'children' => [
            ['title' => 'Customer', 'route' => 'admin.customers.index'],
            ['title' => 'Add Customer', 'route' => 'admin.customers.create'],
        ]
    ],

];
