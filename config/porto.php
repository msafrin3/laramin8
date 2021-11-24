<?php

return [
    'menu' => [
        [
            'title' => 'Main App',
            'url' => '/'
        ],
        [
            'title' => 'Getting started',
            'url' => 'admin/home'
        ],
        [
            'title' => 'Permission Management',
            'url' => 'admin/permission'
        ],
        [
            'title' => 'Role Management',
            'url' => 'admin/role'
        ],
        [
            'title' => 'Meta',
            'url' => 'admin/meta',
            'submenu' => [
                [
                    'title' => 'List Meta',
                    'url' => 'admin/meta'
                ],
                [
                    'title' => 'Add new Meta',
                    'url' => 'admin/meta/add'
                ]
            ]
        ],
        [
            'title' => 'Meta Data',
            'url' => 'admin/metadata',
            'submenu' => [
                [
                    'title' => 'List Metadata',
                    'url' => 'admin/metadata'
                ],
                [
                    'title' => 'Add Metadata',
                    'url' => 'admin/metadata/add'
                ]
            ]
        ]
    ]
];