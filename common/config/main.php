<?php
return [
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'components' => [
//        'cache'       => [
//            'class' => 'yii\caching\FileCache',
//        ],
        'authManager' => [
            'class' => 'yii\rbac\DbManager',
        ],
        'urlManager'  => [
            'class'           => 'common\components\LangUrlManager',
            'enablePrettyUrl' => true,
            'showScriptName'  => false,
            'baseUrl'         => '',
            'rules'           => [
                //'/' => 'site/index',
                '<controller:\w+>/<action:\w+>/*' => '<controller>/<action>',
            ]
        ],
        'mail' => [
            'class' => 'yii\swiftmailer\Mailer',
            'transport' => [
                'class' => 'Swift_SmtpTransport',
                'host' => 'smtp.gmail.com',  // e.g. smtp.mandrillapp.com or smtp.gmail.com
                'username' => 'artemkramov@gmail.com',
                'password' => '10051994aK',
                'port' => '587', // Port 25 is a very common port too
                'encryption' => 'tls', // It is often used, check your provider or mail server specs
            ],
        ],
        'formatter'  => [
            'class'      => 'yii\i18n\Formatter',
            'dateFormat' => 'php:d-m-Y',
            'nullDisplay' => ''
        ]
    ],

];
