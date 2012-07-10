-- phpMyAdmin SQL Dump
-- version 3.3.9
-- http://www.phpmyadmin.net
--
-- 主机: localhost
-- 生成日期: 2012 年 04 月 28 日 07:27
-- 服务器版本: 5.5.8
-- PHP 版本: 5.3.5

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- 数据库: `ficms`
--
CREATE DATABASE `ficms` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `ficms`;

-- --------------------------------------------------------

--
-- 表的结构 `fi_category`
--

CREATE TABLE IF NOT EXISTS `fi_category` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `category_slug` char(200) NOT NULL,
  `name` char(200) NOT NULL,
  `slug` char(200) NOT NULL,
  `active` tinyint(4) NOT NULL,
  `parent` int(11) NOT NULL,
  `displayorder` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- 转存表中的数据 `fi_category`
--

INSERT INTO `fi_category` (`id`, `category_slug`, `name`, `slug`, `active`, `parent`, `displayorder`) VALUES
(1, 'CATEGORY_DEFAULT', '默认分类', 'default', 1, 0, 0);

-- --------------------------------------------------------

--
-- 表的结构 `fi_category_group`
--

CREATE TABLE IF NOT EXISTS `fi_category_group` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` char(200) NOT NULL,
  `slug` char(200) NOT NULL,
  `active` tinyint(4) NOT NULL,
  `description` char(200) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `slug` (`slug`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- 转存表中的数据 `fi_category_group`
--

INSERT INTO `fi_category_group` (`id`, `name`, `slug`, `active`, `description`) VALUES
(1, 'L_DEFAULT_CATEGORY', 'CATEGORY_DEFAULT', 1, '系统默认文章分类');

-- --------------------------------------------------------

--
-- 表的结构 `fi_enum`
--

CREATE TABLE IF NOT EXISTS `fi_enum` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `groupid` int(11) NOT NULL,
  `name` char(200) NOT NULL,
  `value` char(200) NOT NULL,
  `note` char(200) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `groupid` (`groupid`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=25 ;

--
-- 转存表中的数据 `fi_enum`
--

INSERT INTO `fi_enum` (`id`, `groupid`, `name`, `value`, `note`) VALUES
(1, 1, 'L_ENABLE', '1', '启用'),
(2, 1, 'L_DISABLE', '0', '禁用'),
(3, 2, 'L_NORMAL', '0', '正常'),
(4, 2, 'L_SUGGEST', '1', '推荐'),
(6, 3, 'bigint(11)', 'bigint', '数值取值范围0~9223372036854775807'),
(7, 3, 'int(11)', 'int', '数值取值范围0~2147483647'),
(8, 3, 'tinyint(4)', 'tinyint', '数值取值范围0~255'),
(9, 3, 'char(50)', 'char50', 'char 长度0~50'),
(10, 3, 'char(100)', 'char100', 'char 长度0~100'),
(11, 3, 'char(200)', 'char200', 'char 长度0~200'),
(12, 3, 'text', 'text', '长文本'),
(13, 3, 'decimal(8,2)', 'decimal82', '金额'),
(14, 3, 'datetime', 'datetime', '日期时间'),
(15, 4, 'L_INDEX_NONE', '0', ''),
(17, 4, 'L_INDEX_HAVE', '2', ''),
(18, 4, 'L_INDEX_UNIQUE', '3', ''),
(19, 5, 'L_PAGE_TYPE_LIST', '0', '用于数据列出查询'),
(20, 5, 'L_PAGE_TYPE_ADD', '1', '用于数据添加'),
(21, 5, 'L_PAGE_TYPE_EDIT', '2', '用于数据修改');

-- --------------------------------------------------------

--
-- 表的结构 `fi_enum_group`
--

CREATE TABLE IF NOT EXISTS `fi_enum_group` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` char(200) NOT NULL,
  `slug` char(200) NOT NULL,
  `description` char(200) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `slug` (`slug`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=7 ;

--
-- 转存表中的数据 `fi_enum_group`
--

INSERT INTO `fi_enum_group` (`id`, `name`, `slug`, `description`) VALUES
(1, 'L_STATUS', 'ENUM_STATUS', '标示数据是否可用或是否在前台启用'),
(2, 'L_SUGGEST_STATUS', 'ENUM_SUGGEST', '推荐标志，用于标识数据推荐状态'),
(3, 'L_DB_FIELD_TYPE', 'ENUM_DBFIELDTYPE', '模块->数据库表管理->字段数据类型枚举'),
(4, 'L_INDEX', 'ENUM_DBINDEXTYPE', '模块->数据库表管理->字段索引类型列表'),
(5, 'L_PAGE_TYPE', 'ENUM_PAGETYPE', '模块->工作流管理->页面类型');

-- --------------------------------------------------------

--
-- 表的结构 `fi_menu`
--

CREATE TABLE IF NOT EXISTS `fi_menu` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` char(200) NOT NULL,
  `shortkey` char(30) NOT NULL,
  `type` char(10) NOT NULL,
  `module` char(40) NOT NULL,
  `action` char(40) NOT NULL,
  `parent` char(30) NOT NULL,
  `displayorder` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `shortkey` (`shortkey`),
  KEY `type` (`type`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=26 ;

--
-- 转存表中的数据 `fi_menu`
--

INSERT INTO `fi_menu` (`id`, `name`, `shortkey`, `type`, `module`, `action`, `parent`, `displayorder`) VALUES
(1, 'L_ADMIN_HOME', 'ADMIN_HOME', 'admin_menu', 'Index', 'index', '', 0),
(2, 'L_ADMIN_HOME', 'ADMIN_HOME_GROUP', 'admin_menu', '', '', 'ADMIN_HOME', 0),
(3, 'L_ADMIN_INFO', 'ADMIN_INFO', 'admin_menu', 'Index', 'index', 'ADMIN_HOME_GROUP', 0),
(4, 'L_SYSTEM_MANAGE', 'SYSTEM_MANAGE', 'admin_menu', 'System', 'index', 'ADMIN_HOME_GROUP', 0),
(5, 'L_COPYRIGHT', 'ADMIN_COPYRIGHT', 'admin_menu', 'Copyright', 'index', 'ADMIN_HOME_GROUP', 0),
(6, 'L_DATA_MANAGE', 'DATA_MANAGE', 'admin_menu', 'Data', 'index', '', 0),
(7, 'L_CHANNEL_MANAGE', 'CHANNEL_MANAGE', 'admin_menu', 'Channel', 'index', '', 0),
(8, 'L_CHANNEL_MANAGE', 'CHANNEL_MANAGE_GROUP', 'admin_menu', '', '', 'CHANNEL_MANAGE', 0),
(9, 'L_TEMPLATE_MANAGE', 'TEMPLATE_MANAGE', 'admin_menu', 'Template', 'index', '', 0),
(10, 'L_TEMPLATE_MANAGE', 'TEMPLATE_MANAGE_GROUP', 'admin_menu', '', '', 'TEMPLATE_MANAGE', 0),
(11, 'L_MODULE_MANAGE', 'MODULE_MANAGE', 'admin_menu', 'Module', 'index', '', 0),
(12, 'L_MODULE_MANAGE', 'MODULE_MANAGE_GROUP', 'admin_menu', '', '', 'MODULE_MANAGE', 0),
(13, 'L_MODULE_CONFIG', 'MODULE_CONFIG', 'admin_menu', 'Module', 'index', 'MODULE_MANAGE_GROUP', 0),
(14, 'L_PLUGIN_MANAGE', 'PLUGIN_MANAGE', 'admin_menu', 'Enum', 'index', '', 0),
(15, 'L_PLUGIN_MANAGE', 'PLUGIN_MANAGE_GROUP', 'admin_menu', '', '', 'PLUGIN_MANAGE', 0),
(16, 'L_PLUGIN_ENUM_MANAGE', 'PLUGIN_ENUM_MANAGE', 'admin_menu', 'Enum', 'index', 'PLUGIN_MANAGE_GROUP', 0),
(17, 'L_PLUGIN_CATGORY_MANAGE', 'PLUGIN_CATGORY_MANAGE', 'admin_menu', 'Category', 'index', 'PLUGIN_MANAGE_GROUP', 0),
(18, 'L_PLUGIN_TAG_MANAGE', 'PLUGIN_TAG_MANAGE', 'admin_menu', 'Tag', 'index', 'PLUGIN_MANAGE_GROUP', 0),
(19, 'L_PLUGIN_ATTR_MANAGE', 'PLUGIN_ATTR_MANAGE', 'admin_menu', 'Attr', 'index', 'PLUGIN_MANAGE_GROUP', 0),
(20, 'L_PLUGIN_FILE_MANAGE', 'PLUGIN_FILE_MANAGE', 'admin_menu', 'File', 'index', 'PLUGIN_MANAGE_GROUP', 0),
(21, 'L_PLUGIN_MAIL_MANAGE', 'PLUGIN_MAIL_MANAGE', 'admin_menu', 'File', 'index', 'PLUGIN_MANAGE_GROUP', 0),
(22, 'L_PLUGIN_PAY', 'PLUGIN_PAY_GROUP', 'admin_menu', '', '', 'PLUGIN_MANAGE', 0),
(23, 'L_PLUGIN_PAY_CONFIG', 'PLUGIN_PAY_CONFIG', 'admin_menu', 'Pay', 'index', 'PLUGIN_PAY_GROUP', 0),
(24, 'L_PLUGIN_PAY_HISTORY_MANAGE', 'PLUGIN_PAY_HISTORY_MANAGE', 'admin_menu', 'PayHistory', 'index', 'PLUGIN_PAY_GROUP', 0),
(25, 'L_ACCOUNT_MANAGE', 'ACCOUNT_MANAGE', 'admin_menu', 'Account', 'index', '', 0);

-- --------------------------------------------------------

--
-- 表的结构 `fi_module`
--

CREATE TABLE IF NOT EXISTS `fi_module` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` char(200) NOT NULL,
  `keyword` char(50) NOT NULL,
  `active` tinyint(1) NOT NULL,
  `displayorder` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `keyword` (`keyword`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- 转存表中的数据 `fi_module`
--

INSERT INTO `fi_module` (`id`, `name`, `keyword`, `active`, `displayorder`) VALUES
(1, '新闻模块', 'news', 1, 1);

-- --------------------------------------------------------

--
-- 表的结构 `fi_module_field`
--

CREATE TABLE IF NOT EXISTS `fi_module_field` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `table_name` char(50) NOT NULL,
  `name` char(50) NOT NULL,
  `field` char(50) NOT NULL,
  `field_type` char(20) NOT NULL,
  `index` tinyint(4) NOT NULL,
  `param` char(200) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `table_name` (`table_name`,`field`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=31 ;

--
-- 转存表中的数据 `fi_module_field`
--

INSERT INTO `fi_module_field` (`id`, `table_name`, `name`, `field`, `field_type`, `index`, `param`) VALUES
(1, 'news_index', 'ID', 'id', 'int', 1, ''),
(2, 'news_content', 'ID', 'id', 'int', 1, ''),
(3, 'news_index', '网站ID', 'portalid', 'int', 2, ''),
(4, 'news_index', '频道ID', 'channelid', 'int', 2, ''),
(5, 'news_index', '标题图像', 'image', 'char200', 0, ''),
(6, 'news_index', '标题', 'title', 'char200', 0, ''),
(7, 'news_index', '简介', 'introduce', 'char200', 0, ''),
(8, 'news_index', '跳转链接', 'link', 'char200', 0, ''),
(9, 'news_index', '点击', 'click', 'int', 0, ''),
(10, 'news_index', '评价', 'rate', 'tinyint', 0, ''),
(11, 'news_index', '积分', 'score', 'int', 0, ''),
(12, 'news_index', '价格', 'price', 'decimal82', 0, ''),
(13, 'news_index', '推荐', 'suggest', 'tinyint', 0, ''),
(14, 'news_index', '发布', 'publish', 'tinyint', 0, ''),
(15, 'news_index', '保存成文本', 'savetofile', 'tinyint', 0, ''),
(16, 'news_index', '评论', 'reply', 'tinyint', 0, ''),
(17, 'news_index', '可见组', 'visitgroup', 'int', 0, ''),
(18, 'news_index', '创建人UID', 'createuserid', 'int', 0, ''),
(19, 'news_index', '创建人', 'createuser', 'char100', 0, ''),
(20, 'news_index', '最后更新日期', 'updatetime', 'datetime', 0, ''),
(21, 'news_index', '创建日期', 'createtime', 'datetime', 0, ''),
(22, 'news_content', '新闻ID', 'newsid', 'int', 2, ''),
(23, 'news_content', '语种', 'lang', 'char50', 2, ''),
(24, 'news_content', '内容', 'content', 'text', 0, '');

-- --------------------------------------------------------

--
-- 表的结构 `fi_module_page`
--

CREATE TABLE IF NOT EXISTS `fi_module_page` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `module_keyword` char(50) NOT NULL,
  `name` char(50) NOT NULL,
  `filename` char(50) NOT NULL,
  `type` int(11) NOT NULL,
  `note` char(200) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `filename` (`filename`),
  KEY `module_keyword` (`module_keyword`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=6 ;

--
-- 转存表中的数据 `fi_module_page`
--

INSERT INTO `fi_module_page` (`id`, `module_keyword`, `name`, `filename`, `type`, `note`) VALUES
(1, 'news', '新闻管理列表页', 'newslist', 0, '新闻模块文章列表管理页面'),
(4, 'news', '新闻添加页', 'newsadd', 1, '新闻添加页面管理'),
(5, 'news', '新闻修改页', 'newsedit', 2, '新闻信息修改');

-- --------------------------------------------------------

--
-- 表的结构 `fi_module_page_item`
--

CREATE TABLE IF NOT EXISTS `fi_module_page_item` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `pageid` int(11) NOT NULL,
  `type` varchar(50) COLLATE utf8_estonian_ci NOT NULL,
  `name` varchar(50) COLLATE utf8_estonian_ci NOT NULL,
  `value` varchar(200) COLLATE utf8_estonian_ci NOT NULL,
  `order` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_estonian_ci AUTO_INCREMENT=1 ;

--
-- 转存表中的数据 `fi_module_page_item`
--


-- --------------------------------------------------------

--
-- 表的结构 `fi_module_plugin`
--

CREATE TABLE IF NOT EXISTS `fi_module_plugin` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `plugin_keyword` char(50) NOT NULL,
  `module_keyword` char(50) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `plugin_keyword` (`plugin_keyword`,`module_keyword`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=6 ;

--
-- 转存表中的数据 `fi_module_plugin`
--


-- --------------------------------------------------------

--
-- 表的结构 `fi_module_table`
--

CREATE TABLE IF NOT EXISTS `fi_module_table` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `module_keyword` char(50) NOT NULL,
  `table_name` char(50) NOT NULL,
  `forplugin` tinyint(4) NOT NULL,
  `note` char(200) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `table_name` (`table_name`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

--
-- 转存表中的数据 `fi_module_table`
--

INSERT INTO `fi_module_table` (`id`, `module_keyword`, `table_name`, `forplugin`, `note`) VALUES
(1, 'news', 'news_index', 0, '新闻模块文章列表'),
(2, 'news', 'news_content', 0, '新闻模块文章内容表');

-- --------------------------------------------------------

--
-- 表的结构 `fi_news_index`
--

CREATE TABLE IF NOT EXISTS `fi_news_index` (
  `id` bigint(11) NOT NULL AUTO_INCREMENT,
  `portalid` int(11) NOT NULL,
  `channelid` int(11) NOT NULL,
  `image` char(200) NOT NULL,
  `title` char(200) NOT NULL,
  `introduce` char(200) NOT NULL,
  `link` char(200) NOT NULL,
  `click` int(11) NOT NULL,
  `rate` tinyint(4) NOT NULL,
  `score` int(11) NOT NULL,
  `price` decimal(8,2) NOT NULL,
  `suggest` tinyint(4) NOT NULL,
  `publish` tinyint(4) NOT NULL,
  `reply` tinyint(4) NOT NULL,
  `visitgroup` int(11) NOT NULL,
  `createusername` char(100) NOT NULL,
  `createuserid` int(11) NOT NULL,
  `updatetime` int(11) NOT NULL,
  `createtime` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- 转存表中的数据 `fi_news_index`
--


-- --------------------------------------------------------

--
-- 表的结构 `fi_plugin_index`
--

CREATE TABLE IF NOT EXISTS `fi_plugin_index` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `keyword` char(50) NOT NULL,
  `name` char(50) NOT NULL,
  `module` char(50) NOT NULL,
  `note` char(200) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=7 ;

--
-- 转存表中的数据 `fi_plugin_index`
--

INSERT INTO `fi_plugin_index` (`id`, `keyword`, `name`, `module`, `note`) VALUES
(1, 'enum', 'L_PLUGIN_ENUM_MANAGE', 'Enum', '枚举数据维护管理'),
(2, 'category', 'L_PLUGIN_CATGORY_MANAGE', 'Category', '分类插件'),
(3, 'tag', 'L_PLUGIN_TAG_MANAGE', 'Tag', 'TAG管理'),
(4, 'searchattr', 'L_PLUGIN_ATTR_MANAGE', 'Searchattr', '附加查询属性'),
(5, 'file', 'L_PLUGIN_FILE_MANAGE', 'File', '附件管理'),
(6, 'mail', 'L_PLUGIN_MAIL_MANAGE', 'Mail', '邮件发送插件');

-- --------------------------------------------------------

--
-- 表的结构 `fi_plugin_link`
--

CREATE TABLE IF NOT EXISTS `fi_plugin_link` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `plugin_keyword` char(200) NOT NULL,
  `type` char(200) NOT NULL,
  `name` char(200) NOT NULL,
  `link` char(200) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `type` (`type`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- 转存表中的数据 `fi_plugin_link`
--

INSERT INTO `fi_plugin_link` (`id`, `plugin_keyword`, `type`, `name`, `link`) VALUES
(1, 'enum', 'manage', 'L_PLUGIN_ENUM_MANAGE', 'Enum/index');

-- --------------------------------------------------------

--
-- 表的结构 `fi_tag`
--

CREATE TABLE IF NOT EXISTS `fi_tag` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `name` char(50) NOT NULL,
  `active` tinyint(4) NOT NULL,
  `count` bigint(20) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=6 ;

--
-- 转存表中的数据 `fi_tag`
--

INSERT INTO `fi_tag` (`id`, `name`, `active`, `count`) VALUES
(1, 'PHP', 1, 0),
(2, 'ThinkPHP', 1, 0),
(3, 'FireIdeaCMS', 1, 0),
(4, 'Redis', 1, 0),
(5, 'Memcache', 1, 0);
