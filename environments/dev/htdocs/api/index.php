<?php

defined('YII_DEBUG') or define('YII_DEBUG', true);
defined('YII_ENV') or define('YII_ENV', 'dev');

$path = '/../../';

require __DIR__ . $path . 'vendor/autoload.php';
require __DIR__ . $path . 'vendor/yiisoft/yii2/Yii.php';
require __DIR__ . $path . 'common/config/bootstrap.php';
require __DIR__ . $path . 'api/config/bootstrap.php';

$config = yii\helpers\ArrayHelper::merge(
    require __DIR__ . $path . 'common/config/main.php',
    require __DIR__ . $path . 'common/config/main-local.php',
    require __DIR__ . $path . 'api/config/main.php',
    require __DIR__ . $path . 'api/config/main-local.php'
);

(new yii\web\Application($config))->run();
