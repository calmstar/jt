<?php

header('Content-Type:text/html;charset=utf8');
if(version_compare(PHP_VERSION,'5.3.0','<'))  die('require PHP > 5.3.0 !');

define('APP_DEBUG',true);
define('BIND_MODULE','Home');
define('APP_PATH','./Application/');
//解决上传到服务器时U方法失效
define('_PHP_FILE_',$_SERVER['SCRIPT_NAME']);

require './ThinkPHP/ThinkPHP.php';

