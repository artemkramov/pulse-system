<?php
$params = array_merge(
    require(__DIR__ . '/../../common/config/params.php'),
    require(__DIR__ . '/../../common/config/params-local.php'),
    require(__DIR__ . '/params.php'),
    require(__DIR__ . '/params-local.php')
);

return [
    'homeUrl'             => '/',
    'id'                  => 'app-frontend',
    'name'                => 'Pulse system',
    'basePath'            => dirname(__DIR__),
    'bootstrap'           => ['log'],
    'controllerNamespace' => 'frontend\controllers',
    'modules'             => [
        'page'    => [
            'class' => 'frontend\modules\page\Module',
        ],
        'cabinet' => [
            'class' => 'frontend\modules\cabinet\Module',
        ],
        'website' => [
            'class' => 'frontend\modules\website\Module',
        ],
        'api'     => [
            'class' => 'frontend\modules\api\Module',
        ],
    ],
    'components'          => [
        'user'         => [
            'identityClass'   => 'common\models\User',
            'enableAutoLogin' => true,
        ],
        'cache'        => [
            'class' => 'yii\caching\FileCache',
        ],
//        'log'          => [
//            'traceLevel' => YII_DEBUG ? 3 : 0,
//            'targets'    => [
//                [
//                    'class'  => 'yii\log\FileTarget',
//                    'levels' => ['error', 'warning'],
//                ],
//            ],
//        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'request'      => [
            'baseUrl' => '',
            'class'   => 'common\components\LangRequest',
            'parsers' => [
                'application/json' => 'yii\web\JsonParser',
            ],
        ],
        'i18n'         => [
            'class'        => \common\components\I18N::className(),
            'translations' => [
                'yii' => [
                    'class' => \yii\i18n\DbMessageSource::className()
                ]
            ],
        ],
        'urlManager'   => [
            'enablePrettyUrl' => true,
            'showScriptName'  => false,
            'rules'           => [
                '/api/<action>'        => 'api/<action>',
                '/<url:[a-zA-Z0-9-]+>' => 'page/default/show',
            ]
        ],
        'view'         => [
            'theme' => [
                'pathMap' => [
                    '@app/views' => '@frontend/web/themes/diploma'
                ],
            ],
        ],
        'basket'       => [
            'class'        => 'frontend\\components\\BasketComponent',
            'userClass'    => 'common\\models\\User',
            'productClass' => 'backend\\models\\Product',
        ],
        'assetManager' => [
            'linkAssets' => true,
        ],
    ],
    'params'              => $params,
    'defaultRoute'        => 'page/default/show',
];
