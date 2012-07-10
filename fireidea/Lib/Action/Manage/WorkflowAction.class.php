<?php
class WorkflowAction extends ManageAction
{
 	public function index()
	{
		//module infomation
		$id = parseInt($_GET["id"]);
        $Model = M("module");
        $map['id'] = array('eq', $id);
        $result = $Model->where($map)->find();
		
		//get page list
		$Modelpage = M('module_workflow');
		$mappage['module_keyword']=array('eq',$result['keyword']);
		$pagedata = $Modelpage->where($mappage)->order("id desc")->select();
		
		//current module path
		$current_module_path=array(
			array("name"=>$result['name']),
			array("name"=>"L_WORKFLOW_MANAGE"),
		);
		$this->assign("current_system_object",$current_module_path);
		$this->assign("result",$result);
		$this->assign("list",$pagedata);
		$this->display();
	
	}
}
?>