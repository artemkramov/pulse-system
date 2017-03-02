<?php
$params = array_merge(
    require(__DIR__ . '/../../common/config/params.php'),
    require(__DIR__ . '/../../common/config/params-local.php'),
    require(__DIR__ . '/params.php'),
    require(__DIR__ . '/params-local.php')
);

return [
    'homeUrl'             => '/admin',
    'id'                  => 'app-backend',
    'name'                => 'Pulse system',
    'basePath'            => dirname(__DIR__),
    'controllerNamespace' => 'backend\controllers',
    'bootstrap'           => ['log'],
    'modules'             => [
        'users' => [
            'class'         => 'backend\modules\users\Module',
            'controllerMap' => [
                'elfinder' => [
                    'class'     => 'mihaildev\elfinder\PathController',
                    'access'    => ['@'],
                    'root'      => [
                        'path' => 'uploads/users',
                        'name' => 'Files'
                    ],
                    'watermark' => [
                        'source'         => __DIR__ . '/logo.png', // Path to Water mark image
                        'marginRight'    => 5,          // Margin right pixel
                        'marginBottom'   => 5,          // Margin bottom pixel
                        'quality'        => 95,         // JPEG image save quality
                        'transparency'   => 70,         // Water mark image transparency ( other than PNG )
                        'targetType'     => IMG_GIF | IMG_JPG | IMG_PNG | IMG_WBMP, // Target image formats ( bit-field )
                        'targetMinPixel' => 200         // Target image minimum pixel size
                    ]
                ]
            ],
        ],

        'permitold' => [
            'class'  => 'developeruz\db_rbac\Yii2DbRbac',
            'params' => [
                'userClass' => 'app\models\User'
            ],
        ],
        'permit'    => [
            'class' => 'backend\modules\permit\RbacModule',
//            'params' => [
//                'userClass' => 'app\models\User'
//            ],
        ],
        'i18n'      => [
            'class' => 'common\modules\i18n\Module'
        ],
        'settings'  => [
            'class' => 'backend\modules\settings\Module',
        ],
        'dashboard' => [
            'class' => 'backend\modules\dashboard\Module',
        ],
        'content'   => [
            'class' => 'common\modules\content\Module',
        ],

    ],
    'components'          => [
        'user'         => [
            'identityClass'   => 'common\models\User',
            'enableAutoLogin' => true,

        ],
        'log'          => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets'    => [
                [
                    'class'  => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
//        'view' => [
//            'theme' => [
//                'pathMap' => [
//                   '@app/views' => '@vendor/dmstr/yii2-adminlte-asset/example-views/yiisoft/yii2-app'
//                ],
//            ],
//       ],
        'assetManager' => [
            'bundles' => [
                'dmstr\web\AdminLteAsset' => [
                    'skin' => 'skin-purple',
                ],
            ],
            //'linkAssets' => true,
        ],

        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName'  => false,
            'class'           => 'backend\\components\\UrlManagerExtend',
            'rules'           => [
                [
                    'class'      => 'yii\rest\UrlRule',
                    'controller' => [
                        'api/health'
                    ]
                ]
            ],
        ],
        'siteHelper' => [
            'class' => 'backend\components\SiteHelper'
        ],
        'request'    => [
            'class'   => 'common\components\LangRequest',
            'parsers' => [
                'application/json' => 'yii\web\JsonParser',
            ],
            'baseUrl' => '/admin',
        ],
        'language'   => 'ru-RU',
        'i18n'       => [
            'class'        => \common\components\I18N::className(),
            'translations' => [
                'yii' => [
                    'class' => \yii\i18n\DbMessageSource::className()
                ]
            ],
        ],


    ],
    'params'              => $params
];
