<?php

use api\modules\v1\Module;
use common\components\UserUrlManager;
use common\models\User;
use yii\i18n\Formatter;
use yii\log\FileTarget;
use yii\web\JsonParser;
use yii\web\JsonResponseFormatter;
use yii\web\Response;

$params = array_merge(
    require __DIR__ . '/../../common/config/params.php',
    require __DIR__ . '/../../common/config/params-local.php',
    require __DIR__ . '/params.php',
    require __DIR__ . '/params-local.php'
);

return [
    'id' => 'app-api',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'controllerNamespace' => 'api\controllers',
    'aliases' => [
        '@images' => '/uploads',
    ],

    'modules' => [
        'v1' => [
            'class' => Module::class,
        ],
    ],
    'defaultRoute' => '/api',

    'components' => [
        'request' => [
            'csrfParam' => '_csrf-api',
            'baseUrl' => '/api',
            'enableCsrfValidation' => false,
            'parsers' => [
                'application/json' => JsonParser::class,
            ]
        ],

        'user' => [
            'identityClass' => User::class,
            'enableAutoLogin' => true,
            'identityCookie' => ['name' => '_identity-api', 'httpOnly' => true, 'path' => '/'],
        ],

        'session' => [
            'name' => 'advanced-api',
        ],

        'response' => [
            // ...
            'formatters' => [
                Response::FORMAT_JSON => [
                    'class' => JsonResponseFormatter::class,
                    'prettyPrint' => YII_DEBUG, // use "pretty" output in debug mode
                    'encodeOptions' => JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE,
                    // ...
                ],
            ],
            'on beforeSend' => static function ($event) {
                $response = $event->sender;

                if (!is_string($response->data)) {
                    $response_data = [
                        'success' => $response->isSuccessful,
                    ];

                    // translate messages
                    if (isset($response->data['message'])) {
                        $message = $response->data['message'];
                        $response->data['message'] = is_string($message)
                            ? Yii::t('app', $response->data['message'])
                            : $message;
                    }

                    // send original response data
                    if ($response->data) {
                        $response_data['data'] = $response->data['data'] ?? $response->data;
                        $response_data['data']['status'] = Yii::$app->response->statusCode;
                    }

                    $response->data = $response_data;
                }

                // Suppress OK status
                if ($response->isSuccessful) {
                    $response->statusCode = 200;
                }
            },
        ],

        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => FileTarget::class,
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
            'hideRoot' => true,
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
            ],
        ],
    ],
    'params' => $params,
];
