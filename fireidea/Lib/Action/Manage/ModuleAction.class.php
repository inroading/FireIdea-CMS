<?php
class ModuleAction extends ManageAction
{

    public function index()
    {
		//new Model
		$Model = M("module");
		 //query and list
        $list = $Model->order("id desc")->select();
		//for template show
        $this->assign("list", $list);
        $this->display();
    }

    public function add()
    {
		//status select box
		import("@.API.EnumAPI");
        $dropdown_status=EnumAPI::getSelect("ENUM_STATUS","active","");
		$this->assign("DROPDOWN_STATUS",$dropdown_status);
		
		//current module path
		$current_module_path=array(
			array("name"=>"L_ADD"),
		);
		$this->assign("current_system_object",$current_module_path);
		
        $this->display();
    }

    public function addnew()
    {
        $Model = D("module");

        $validate = array(
            array('name', 'require', L('L_MUST_FILL') . L('L_NAME')),
            array('active', 'number', L('L_MUST_NUMBER') . L('L_STATUS')),
            array('displayorder', 'number', L('L_MUST_NUMBER') . L('L_ORDER')),
        );

        $Model->setProperty("_validate", $validate);
        $data = $Model->create();

        if (!$data)
        {
            $this->error($Model->getError());
        }
        else
        {
            if ($Model->add($data))
            {
                $this->success(L("L_CREATE_SUCCESS"));
            }
        }
    }

    public function edit()
    {
        $id = parseInt(trim($_GET["id"]));

        $Model = M("module");
        $map['id'] = array('eq', $id);
        $result = $Model->where($map)->find();

        if (!$result)
        {
            $this->error(L("L_PARAMETER_ERROR_PLEASE_TRY_AGAIN"));
        }
		//status select box
		import("@.API.EnumAPI");
        $dropdown_status=EnumAPI::getSelect("ENUM_STATUS","active",$result["active"]);
		$this->assign("DROPDOWN_STATUS",$dropdown_status);
		
        $this->assign("vo", $result);
		
		//current module path
		$current_module_path=array(
			$result,
			array("name"=>"L_EDIT"),
		);
		$this->assign("current_system_object",$current_module_path);
		
        $this->display();
    }

    public function update()
    {

        $Model = D("module");
        $validate = array(
            array('name', 'require', L('L_MUST_FILL') . L('L_NAME')),
            array('active', 'number', L('L_MUST_NUMBER') . L('L_STATUS')),
            array('displayorder', 'number', L('L_MUST_NUMBER') . L('L_ORDER')),
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
            $this->success(L("L_UPDATE_SUCCESS"));
        }
    }

    public function del()
    {
        $id = parseInt($_GET["id"]);

        $Model = D("module");

        if (!$id > 0)
        {
            $this->error(L("L_PARAMETER_ERROR_PLEASE_TRY_AGAIN"));
        }

        if ($Model->delete($id))
        {
            $this->assign("jumpUrl", U("index"));
            $this->success(L("L_DELETE_SUCCESS"));
        }
        else
        {
            $this->error(L("L_FAILTURE_PLEASE_CONTACT_ADMINISTRATOR_TO_SOLVE"));
        }
    }
}
?>