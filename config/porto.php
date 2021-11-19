<?php

return [
    'menu' => [
        [
            'title' => 'Main App',
            'url' => '/'
        ],
        [
            'title' => 'Getting started',
            'url' => '/admin'
        ],
        [
            'title' => 'Permission Management',
            'url' => '#',
            'submenu' => [
                [
                    'title' => 'List Permission',
                    'url' => '/admin/permission'
                ],
                [
                    'title' => 'Add New Permission',
                    'url' => '/admin/permission/add'
                ]
            ]
        ],
        [
            'title' => 'Role Management',
            'url' => '#',
            'submenu' => [
                [
                    'title' => 'List Role',
                    'url' => '/admin/role'
                ],
                [
                    'title' => 'Add new Role',
                    'url' => '/admin/role/add'
                ]
            ]
        ]
    ]
];