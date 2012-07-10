<?php
return array(
	
	/* 项目设定 */
    'APP_GROUP_LIST'        => 'Home,Manage',      // 项目分组设定,多个组之间用逗号分隔,例如'Home,Admin'
	'LOAD_EXT_CONFIG'		=>'dynamic',		   //附加加载配置
	//'APP_AUTOLOAD_PATH' => 'Think.Util.,ORG.Util.,@.Common.',  //自动加载类库
	
    /* 数据库设置 */
    'DB_SUFFIX'             => '',          // 数据库表后缀
	'DB_PREFIX'             => 'fi_',		// 数据库表前缀
	'DB_FIELDTYPE_CHECK'    => false,       // 是否进行字段类型检查
    'DB_FIELDS_CACHE'       => true,        // 启用字段缓存
    'DB_CHARSET'            => 'utf8',      // 数据库编码默认采用utf8
	'DB_SQL_BUILD_CACHE' 	=> true,		//SQL解析缓存
	
	/* 数据缓存设置 */
    'DATA_CACHE_COMPRESS'   => false,   // 数据缓存是否压缩缓存
    'DATA_CACHE_CHECK'		=> false,   // 数据缓存是否校验缓存
    'DATA_CACHE_SUBDIR'		=> true,    // 使用子目录缓存 (自动根据缓存标识的哈希创建子目录)
    'DATA_PATH_LEVEL'       => 3,        // 子目录缓存级别

    /* 错误设置 */
    'ERROR_MESSAGE' => '您浏览的页面暂时发生了错误！请稍后再试～',//错误显示信息,非调试模式有效
    'ERROR_PAGE'    => '',	// 错误定向页面
 
    /* 语言设置 */
    'LANG_SWITCH_ON'        => true,   // 默认关闭多语言包功能
    'LANG_AUTO_DETECT'      => true,   // 自动侦测语言 开启多语言功能后有效
	
    /* 日志设置 */
    'LOG_EXCEPTION_RECORD'  => true,    // 是否记录异常信息日志(默认为开启状态)
    'LOG_FILE_SIZE'         => 2097152,	// 日志文件大小限制

    /* SESSION设置 */
    'SESSION_AUTO_START'    => true,    // 是否自动开启Session

    /* 模板引擎设置 */
    'TMPL_ACTION_ERROR'     => 'Public:tips', // 默认错误跳转对应的模板文件
    'TMPL_ACTION_SUCCESS'   => 'Public:tips', // 默认成功跳转对应的模板文件

    /* URL设置 */
    'URL_ROUTER_ON'         => false,   // 是否开启URL路由
    'URL_MODEL'      		=> 2,       // URL访问模式
    'URL_HTML_SUFFIX'       => '.html',  // URL伪静态后缀设置
);
?>