<?php
class DBManage {
	
	//table op
	public static function add_table($table)
	{
		$model = M();
        $result=$model->execute("
CREATE TABLE IF NOT EXISTS `fi_news` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `portalid` int(11) NOT NULL,
  `channelid` int(11) NOT NULL,
  `image` char(200) NOT NULL,
  `title` char(200) NOT NULL,
  `introduce` char(255) NOT NULL,
  `link` char(200) NOT NULL,
  `click` int(11) NOT NULL,
  `rate` tinyint(4) NOT NULL,
  `score` int(11) NOT NULL,
  `price` decimal(8,2) NOT NULL,
  `suggest` tinyint(4) NOT NULL,
  `enable` tinyint(4) NOT NULL,
  `canreply` tinyint(4) NOT NULL,
  `visitgroup` int(11) NOT NULL,
  `createuser` char(100) NOT NULL,
  `updatetime` int(11) NOT NULL,
  `createtime` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;");
        return $result;
	}
	
	public static function del_table($table)
	{
		$model = M();
        $result=$model->execute("DROP TABLE `".$table."`;");
        return $result;
	}
	
	public static function change_table_name($table,$newtable)
	{
		$model = M();
        $result=$model->execute("ALTER TABLE `".$table."` RENAME `".$newtable."`;");;
        return $result;
	}
	
	//db field op
    public static function del_field($table,$fieldname) {
        $model = M();
        $result=$model->execute("ALTER TABLE `".$table."` DROP `".$fieldname."`;");;
        return $result;
    }
	
	public static function add_field($table,$fieldname,$type,$len) {
        $model = M();
        $result=$model->execute("ALTER TABLE `".$table."` ADD `".$fieldname."` `".$type."(".$len.")"."` NOT NULL ;");;
        return $result;
    }
	
	public static function change_field($table,$fieldname,$newname,$type,$len)
	{
		$model = M();
        $result=$model->execute("ALTER TABLE `".$table."` CHANGE `".$fieldname."` `".$newname."` `".$type."(".$len.")"."` NOT NULL;");;
        return $result;
	}
	
	//index
	public static function add_index($table,$field)
	{
		$model = M();
        $result=$model->execute("ALTER TABLE `".$table."` add index `".$table."` (".$field.");");;
        return $result;
	}
	
	public static function del_index($table,$field)
	{
		$model = M();
        $result=$model->execute("ALTER TABLE `".$table."` drop index `".$table."` ;");;
        return $result;
	}
	
	// unique index op
	public static function add_unique_index($table,$field)
	{
		$model = M();
        $result=$model->execute("ALTER TABLE `".$table."` add unique ".$field."_unique(".$field.");");
        return $result;
	}
	
	public static function del_unique_index($table,$field)
	{
		$model = M();
        $result=$model->execute("ALTER TABLE `".$table."` drop unique ".$field."_unique;");
        return $result;
	}

}
?>