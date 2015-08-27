<?php

//应用代码路径
define('APP_PATH',  dirname(__DIR__) .'/app/');
//运行时数据目录
define('DATA_PATH', dirname(__DIR__) .'/data/');

if ($_SERVER['HTTP_HOST'] == 'lamp.test.com') {
    define('RUN_MODE', 'dev');
    define('DEBUG', true);
    require '/data/htdocs/framework/system/App.php';
} else {
    define('RUN_MODE', 'pro');
    require dirname(__DIR__) .'/../framework/src/system/App.php';
}

App::bootstrap();
App::run();
