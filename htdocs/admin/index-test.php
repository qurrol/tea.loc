<?php

// NOTE: Make sure this file is not accessible when deployed to production
if (!in_array(@$_SERVER['REMOTE_ADDR'], ['127.0.0.1', '::1'])) {
    die('You are not allowed to access this file.');
}

defined('YII_DEBUG') or define('YII_DEBUG', true);
defined('YII_ENV') or define('YII_ENV', 'test');

$path = '/../../';

require __DIR__ . $path . 'vendor/autoload.php';
require __DIR__ . $path . 'vendor/yiisoft/yii2/Yii.php';
require __DIR__ . $path . 'common/config/bootstrap.php';
require __DIR__ . 'admin/config/bootstrap.php';

$config = yii\helpers\ArrayHelper::merge(
    require __DIR__ . $path . 'common/config/main.php',
    require __DIR__ . $path . 'common/config/main-local.php',
    require __DIR__ . $path . 'common/config/test.php',
    require __DIR__ . $path . 'common/config/test-local.php',
    require __DIR__ . $path . 'admin/config/main.php',
    require __DIR__ . $path . 'admin/config/main-local.php',
    require __DIR__ . $path . 'admin/config/test.php',
    require __DIR__ . $path . 'admin/config/test-local.php'
);

(new yii\web\Application($config))->run();
