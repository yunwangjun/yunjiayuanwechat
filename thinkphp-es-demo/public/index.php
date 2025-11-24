<?php
// public/index.php
define('APP_PATH', __DIR__ . '/../app/');

// 加载基础文件
require __DIR__ . '/../vendor/autoload.php';

// 执行应用
$app = new \think\App();
$app->run()->send();