<?php
return  array(
	'SHOW_PAGE_TRACE'       => false,	//debug trace
	'APP_FILE_CASE'         => true,   // 是否检查文件的大小写 对Windows平台有效
	
	/* Cookie设置 */
    'COOKIE_EXPIRE'         => 3600,    // Coodie有效期	
    'COOKIE_DOMAIN'         => '',      // Cookie有效域名
    'COOKIE_PATH'           => '/',     // Cookie路径
    'COOKIE_PREFIX'         => 'FICMS',      // Cookie前缀 避免冲突

    /* 数据库设置 */
    'DB_TYPE'               => 'mysql',     // 数据库类型
	'DB_HOST'               => 'localhost', // 服务器地址
	'DB_NAME'               => 'ficms',		// 数据库名
	'DB_USER'               => 'root',      // 用户名
	'DB_PWD'                => 'db',		// 密码
	'DB_PORT'               => 3306,        // 端口
	
    'DB_DEPLOY_TYPE'        => 0,			// 数据库部署方式:0 集中式(单一服务器),1 分布式(主从服务器)
    'DB_RW_SEPARATE'        => false,       // 数据库读写是否分离 主从式有效
	
	//mail
	'MAIL_TYPE'				=>'php',//php|sendmail|smtp
	'MAIL_HOST'				=>'',//smtp服务器
	'MAIL_PORT'				=>25,//smtp port
	'MAIL_LOGINNAME'		=>'',//smtp login
	'MAIL_PASSWORD'			=>'',//smtp passwod
	'MAIL_SECURE'			=>'',//tls if is gmail
	'MAIL_ADDRESS'			=>'xcl_rockman@qq.com',
	'MAIL_SENDERNAME'		=>'FireIdeaCMS',
	
	//缓冲
	'DATA_CACHE_TIME'		=> 30,      // 数据缓存有效期
	'DATA_CACHE_TYPE'		=> 'File',  // 数据缓存类型,支持:File|Db|Apc|Memcache|Shmop|Sqlite| Xcache|Apachenote|Eaccelerator
);
?>