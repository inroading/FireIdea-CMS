<?php
class ListAPI {

	//列表项
	public $fieldList=array(
			"id"=>array("pk"=>1,"list"=>1,"name"=>"标识","cansearch"=false,"searchtype"="","itemtemplate"=""),
			"name"=>array("pk"=>0,"list"=>1,"name"=>"姓名","cansearch"=true,"searchtype"="=","itemtemplate"=""),
			"link"=>array("itemtemplate"=""),
	);

	public $table=array();
	public $pagesize=20;
	public $orderby="id desc";
	public $inputParam= array('id');
	public $currentpage=1;
	public $other;
	
	public $headerhtml;
	public $bottomhtml;

	public function getArray($where,$order,$currentpage)
	{
        
	}
}
?>
