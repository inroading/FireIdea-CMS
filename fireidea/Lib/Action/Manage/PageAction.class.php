<?php
class PageAction extends ManageAction
{
 	public function index()
	{
		$id=parseInt($_POST['id']);
		$Model=M('module_page');
		
		$map['id'] = array('eq', $id);
        $result = $Model->where($map)->find();

        if (!$result)
        {
            $this->error(L("L_PARAMETER_ERROR_PLEASE_TRY_AGAIN"));
        }
		
		//current module path
		$current_module_path=array(
			array("name"=>"L_WORKFLOW_MANAGE"),	
			array("name"=>$result['name']),
			array("name"=>"L_MANAGE"),
		);
		$this->assign("current_system_object",$current_module_path);
		$this->assign("vo", $result);
		$this->display();
	}
	public function add()
	{
		$module = FP($_GET["module"]);
		
        $Model = M("module");
        $map['keyword'] = array('eq', $module);
        $result = $Model->where($map)->find();
		
		import("@.API.EnumAPI");
        $dropdown_status=EnumAPI::getSelect("ENUM_PAGETYPE","type","");
		
		//current module path
		$current_module_path=array(
			array("name"=>$result['name']),
			array("name"=>"L_WORKFLOW_MANAGE"),
			array("name"=>"L_ADD"),
		);
		$this->assign("current_system_object",$current_module_path);
		$this->assign("ENUM_PAGETYPE",$dropdown_status);
		$this->assign("module",$module);
		$this->display();
	}
	public function addnew()
	{
		$Model=M("module_page");
		
		$validate = array(
			array('name', 'require', L('L_MUST_FILL') . L('L_NAME')),
            array('filename', 'require', L('L_MUST_FILL') . L('L_FILENAME')),
			array('type', 'require', L('L_MUST_FILL') . L('L_PAGE_TYPE')),
        );
		$Model->setProperty("_validate", $validate);
        $result = $Model->create();

        if (!$result)
        {
            $this->error($Model->getError());
        }
        else
        {
            $Model->add($result);
            $this->success(L("L_CREATE_SUCCESS"));
        }
	}
	public function edit()
	{
		$id=parseInt($_GET['id']);
		$Model=M('module_page');
		
		$map['id'] = array('eq', $id);
        $result = $Model->where($map)->find();

        if (!$result)
        {
            $this->error(L("L_PARAMETER_ERROR_PLEASE_TRY_AGAIN"));
        }
		
		import("@.API.EnumAPI");
        $typename=EnumAPI::getName("ENUM_PAGETYPE",$result['type']);
		$this->assign("ENUM_PAGETYPE",L($typename));
		
		//current module path
		$current_module_path=array(
			array("name"=>"L_WORKFLOW_MANAGE"),	
			array("name"=>$result['name']),
			array("name"=>"L_EDIT"),
		);
		$this->assign("current_system_object",$current_module_path);
		
		$this->assign("vo", $result);
		$this->display();
	}
	public function update()
	{
		$Model=M("module_page");
		
		$validate = array(
			array('name', 'require', L('L_MUST_FILL') . L('L_NAME')),
        );
		$Model->setProperty("_validate", $validate);
        $result = $Model->create();

        if (!$result)
        {
            $this->error($Model->getError());
        }
        else
        {
            $Model->save($result);
            $this->success(L("L_CREATE_SUCCESS"));
        }
	}
	public function del()
	{
		$id = parseInt($_GET["id"]);

        $Model = D("module_page");
		
		$map['id'] = array('eq', $id);
        $result = $Model->where($map)->find();
		
        if (!$result)
        {
            $this->error(L("L_PARAMETER_ERROR_PLEASE_TRY_AGAIN"));
        }

        if ($Model->delete($id))
        {
            $this->success(L("L_DELETE_SUCCESS"));
        }
        else
        {
            $this->error(L("L_FAILTURE_PLEASE_CONTACT_ADMINISTRATOR_TO_SOLVE"));
        }
	}
}
?>