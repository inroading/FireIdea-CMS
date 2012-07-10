<?php
class EnumAction extends ManageAction
{

    public function index()
    {
		//new Model
		$Model = M("enum_group");
		//count for page
		$count = $Model->count();
		//page lib
		import("ORG.Util.Page");
		$Page = new Page($count,10);
		$show = $Page->show(); 
		 //query and list
        $list = $Model->order("id desc")->limit($Page->firstRow.','.$Page->listRows)->select();
		//for template show
        $this->assign("list", $list);
		$this->assign('page',$show);
        $this->display();
    }

    public function add()
    {
		//current module path
		$current_module_path=array(
			array("name"=>"L_ADD"),
		);
		$this->assign("current_system_object",$current_module_path);
		
        $this->display();
    }

    public function addnew()
    {
        $Model = D("enum_group");

        $validate = array(
            array('name', 'require', L('L_MUST_FILL') . L('L_NAME')),
            array('slug', 'require', L('L_MUST_FILL') . L('L_SLUG')),
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
				$this->assign("jumpUrl", U("index"));
                $this->success(L("L_CREATE_SUCCESS"));
            }
        }
    }

    public function edit()
    {
        $id = parseInt(trim($_GET["id"]));

        $Model = M("enum_group");
        $map['id'] = array('eq', $id);
        $result = $Model->where($map)->find();

        if (!$result)
        {
            $this->error(L("L_PARAMETER_ERROR_PLEASE_TRY_AGAIN"));
        }

        $this->assign("vo", $result);
		
		$current_module_path=array(
			$result,
			array("name"=>"L_EDIT"),
		);
		$this->assign("current_system_object",$current_module_path);
		
        $this->display();
    }

    public function update()
    {

        $Model = D("enum_group");
        $validate = array(
            array('name', 'require', L('L_MUST_FILL') . L('L_NAME')),
            array('slug', 'require', L('L_MUST_FILL') . L('L_SLUG')),
        );

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

        $Model = D("enum_group");
		$enumModel = D("enum");
		
        if (!$id > 0)
        {
            $this->error(L("L_PARAMETER_ERROR_PLEASE_TRY_AGAIN"));
        }

        if ($Model->delete($id))
        {
			$enumModel->where('groupid='.$id)->delete();
            $this->assign("jumpUrl", U("index"));
            $this->success(L("L_DELETE_SUCCESS"));
        }
        else
        {
            $this->error(L("L_FAILTURE_PLEASE_CONTACT_ADMINISTRATOR_TO_SOLVE"));
        }
    }
	
    public function manage()
    {
        $id = parseInt($_POST["id"]);

        $Model = D("enum_group");
		$enumModel = D("enum");
		
        $map['id'] = array('eq', $id);
        $record = $Model->where($map)->find();
		$result = $enumModel->where("groupid=".$id)->select();
		
        if (!$record)
        {
            $this->error(L("L_PARAMETER_ERROR_PLEASE_TRY_AGAIN"));
        }

        $this->assign("vo", $result);
		$this->assign("record", $record);
        $this->display();
    }
	public function add_item()
	{
		if ($_POST["gid"]<=0)
        {
            $this->error(L("L_PARAMETER_ERROR_PLEASE_TRY_AGAIN"));
        }
		$gid=parseInt($_POST["gid"]);

		$Model = D("enum_group");
		
        $map['id'] = array('eq', $gid);
        $record = $Model->where($map)->find();
		
		if (!$record)
        {
            $this->error(L("L_PARAMETER_ERROR_PLEASE_TRY_AGAIN"));
        }
		
		$this->assign("record",$record);
		$this->assign("groupid",$gid);
		$this->display();
	}
	public function addnew_item()
	{
		if ($_POST["groupid"]<=0)
        {
            $this->error(L("L_PARAMETER_ERROR_PLEASE_TRY_AGAIN"));
        }
		$Model = D("enum");
		
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

    public function del_item()
    {
        $id = parseInt($_POST["id"]);

		$Model = D("enum");
		
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
	public function update_item()
	{
		if ($_POST["groupid"]<=0)
        {
            $this->error(L("L_PARAMETER_ERROR_PLEASE_TRY_AGAIN"));
        }
		
		$id_array = $_POST["id"];
		$name_array = $_POST["name"];
		$value_array = $_POST["value"];
		$note_array = $_POST["note"];
		$groupid=$_POST["groupid"];
		
		$Model=D("enum");
		
		for($i=0;$i<count($id_array);$i++)
		{
			$dat=array(
				 "groupid"=>$groupid,
				 "id"=>parseInt($id_array[$i]),
				 "name"=>FP($name_array[$i]),
				 "value"=>FP($value_array[$i]),
				 "note"=>FP($note_array[$i]),
			 );
			 if($id_array[$i]>0)
			 {
				 $Model->save($dat);
			 }
		}
		$this->success(L("L_UPDATE_SUCCESS"));
	}
	
	public function install($moduleinfo,$plugininfo)
	{
		$dbprefix=C('db_prefix').$moduleinfo['keyword'].'_'.$plugininfo['keyword'].'_';
	}
	
	public function uninstall($moduleinfo,$plugininfo)
	{
		$dbprefix=C('db_prefix').$moduleinfo['keyword'].'_'.$plugininfo['keyword'].'_';
	}
}

?>