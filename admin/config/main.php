<?php

use common\components\UserUrlManager;
use yii\i18n\Formatter;

$baseUrl = str_replace('/admin', '', UserUrlManager::getDomainUrl('@admin'));
$module = '/admin';

$params = array_merge(
    require __DIR__ . '/../../common/config/params.php',
    require __DIR__ . '/../../common/config/params-local.php',
    require __DIR__ . '/params.php',
    require __DIR__ . '/params-local.php'
);

return [
    'id' => 'app-admin',
    'homeUrl' => $baseUrl . $module,
    'basePath' => dirname(__DIR__),

    'controllerNamespace' => 'admin\controllers',

    'bootstrap' => ['log'],
    'modules' => [],
    'components' => [
        'request' => [
            'csrfParam' => '_csrf-admin',
        ],

        'user' => [
            'identityClass' => 'common\models\User',
            'enableAutoLogin' => true,
            'identityCookie' => ['name' => '_identity-user', 'httpOnly' => true],
        ],

        'session' => [
            'name' => 'advanced-admin',
        ],

        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => \yii\log\FileTarget::class,
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],

        'errorHandler' => [
            'errorAction' => 'site/error',
        ],

        'formatter' => [
            'class' => Formatter::class,
            'decimalSeparator' => ',',
            'thousandSeparator' => ' ',
            'currencyCode' => 'RUB',
            'dateFormat' => 'php: d/m/Y',
            'datetimeFormat' => 'php: d/m/Y H:i',
        ],

        'urlManager' => [
            'class' => UserUrlManager::class,
            'root' => '/htdocs',
            'suffix' => '',
            'hideRoot' => true,
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
//                '/' => 'site/index',
            ],
        ],
    ],
    'params' => $params,
];
