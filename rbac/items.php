<?php
return [
    'administrator' => [
        'type' => 1,
        'children' => [
            'entreprise-admin',
            'entreprise-create',
            'entreprise-update',
            'entreprise-delete',
            'ville-admin',
            'category-admin',
        ],
    ],
    'entreprise-admin' => [
        'type' => 2,
    ],
    'entreprise-create' => [
        'type' => 2,
    ],
    'entreprise-update' => [
        'type' => 2,
    ],
    'entreprise-update-my' => [
        'type' => 2,
        'ruleName' => 'MyEntrepriseRule',
        'children' => [
            'entreprise-update',
        ],
    ],
    'entreprise-delete' => [
        'type' => 2,
    ],
    'entreprise-delete-my' => [
        'type' => 2,
        'ruleName' => 'MyEntrepriseRule',
        'children' => [
            'entreprise-delete',
        ],
    ],
    'entreprise' => [
        'type' => 1,
        'children' => [
            'entreprise-admin',
            'entreprise-create',
            'entreprise-update-my',
            'entreprise-delete-my',
        ],
    ],
    'ville-admin' => [
        'type' => 2,
    ],
    'category-admin' => [
        'type' => 2,
    ],
];
