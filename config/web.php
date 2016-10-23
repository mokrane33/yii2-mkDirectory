<?php

$params = require(__DIR__ . '/params.php');

$config = [
    'id' => 'annuaire-sts-lyxeo-algerie',
    'defaultRoute'=>'entreprise/index',

    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'as access' => [
        'class' => 'mdm\admin\components\AccessControl',
        'allowActions' => [
            'site/*',
            'user/*',
            //'admin/*',
            'gii/*',
            'entreprise/*',
            'ville/*',
            'category/*',
            '*',
        ]
    ],
    'components' => [
        'authManager' => [
            'class' => 'yii\rbac\PhpManager',
            'assignmentFile' => '@app/rbac/assignments.php',
            'ruleFile'       => '@app/rbac/rules.php',
            'itemFile'       => '@app/rbac/items.php'
        ],
        'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => 'maville',
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            // send all mails to a file by default. You have to set
            // 'useFileTransport' to false and configure a transport
            // for the mailer to send real emails.
            'useFileTransport' => true,
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'db' => require(__DIR__ . '/db.php'),
        //*
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'suffix' => '.html',
            'rules' => [
                'entreprise-detail/<slug>' => 'entreprise/view',
                'entreprise-categorie/<slug>' => 'entreprise/category',
                'entreprise-ville/<slug>' => 'entreprise/ville',
                '<controller>/<action:\w+>' => '<controller>/<action>',
//                '<module>/<action:\w+>' => '<module>/default/<action>',
                '<module:category>-detail' => '<module>/default/voire',
            ]
        ],
       // */
    ],
    'modules' => [
        'gridview' =>  [
            'class' => '\kartik\grid\Module'
            // enter optional module parameters below - only if you need to
            // use your own export download action or custom translation
            // message source
            // 'downloadAction' => 'gridview/export/download',
            // 'i18n' => []
        ],
        'admin' => [
            'class' => 'mdm\admin\Module',
        ],
        'user' => [
            'class' => 'dektrium\user\Module',
            'modelMap' => [
                'User' => [
                    'class' => 'app\models\User',
                ],
//                'RegistrationForm' => [
//                    'class' => 'app\models\RegistrationForm',
//                ],
                'UserSearch' => [
                    'class' => 'app\models\UserSearch',
                ],
//                'Profile' => [
//                    'class' => 'app\models\Profile',
//                ],

            ],
        ],
        'category' => [
            'class' => 'app\modules\lyxeocat\Category',
            'controllerMap'=>['default'=>'app\controllers\CategoryController']

        ],
        'ville' => [
            'class' => 'app\modules\lyxeoville\Ville',
            'controllerMap'=>['default'=>'app\controllers\VilleController']
        ],
    ],
    'params' => $params,
];

if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = [
        'class' => 'yii\debug\Module',
    ];

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
    ];
}

return $config;
