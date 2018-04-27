<?php
/**
 * Created by PhpStorm.
 * User: 陈文星
 * Date: 2018/4/13
 * Time: 14:16
 */
header('Content-Type:text/html;charset=utf8');

if(version_compare(PHP_VERSION,'5.3.0','<'))  die('require PHP > 5.3.0 !');

define('APP_DEBUG',true);
define('BIND_MODULE','Admin');
define('APP_PATH','./Application/');

//定义工作路径
define('WORKING_PATH', str_replace('\\','/',__DIR__));
//定义上传根目录
define('UPLOAD_ROOT_PATH', '/Public/Upload/');

//解决上传到服务器时U方法失效
define('_PHP_FILE_',$_SERVER['SCRIPT_NAME']);

require './ThinkPHP/ThinkPHP.php';

