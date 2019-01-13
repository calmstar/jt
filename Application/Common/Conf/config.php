<?php
return array(
	//'配置项'=>'配置值'
	//模版常量
	'TMPL_PARSE_STRING' => array(
                        '__ADMIN__' => '/Public/Admin'
                    ),

	/* 数据库设置 */
    'DB_TYPE'               =>  'mysql',     // 数据库类型
    'DB_HOST'               =>  'localhost', // 服务器地址
    'DB_NAME'               =>  'jt_vagr_com',          // 数据库名
    'DB_USER'               =>  'jt_vagr_com',      // 用户名
    'DB_PWD'                =>  'Dh7GnERzxmRNDJKb',          // 密码
    'DB_PORT'               =>  '3306',        // 端口
    'DB_PREFIX'             =>  'jt_',    // 数据库表前缀

    'SHOW_PAGE_TRACE' => false,

    // 允许访问的模块列表'
//    'MODULE_ALLOW_LIST'    =>    array('Home','Admin'),
//    'DEFAULT_MODULE'       =>    'Home',  // 默认模块
//    'URL_MODULE_MAP'       =>    array('manager'=>'admin'),

    // 开启子域名配置
//    'APP_SUB_DOMAIN_DEPLOY'   =>    1,
    // 192.168.79.41指向Home模块
//    'APP_SUB_DOMAIN_RULES'    =>    array( '192.168.79.21'  => 'Home',),



);