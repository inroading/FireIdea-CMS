<?php
class TagAction extends ManageAction
{

    public function index()
    {
		$map=array();
		if(isset($_GET["keyword"]) && $_GET["keyword"]!=""	)
		{
			$keyword=FP($_GET["keyword"]);
			$map['name'] = array('like', "%".$keyword."%");
			$this->assign("keyword",$keyword);
		}

		//new Model
		$Model = M("tag");
		//count for page
		$count = $Model->where($map)->count();
		//page lib
		import("ORG.Util.Page");
		$Page = new Page($count,10);
		$show = $Page->show(); 
		 //query and list
        $list = $Model->where($map)->order("id desc")->limit($Page->firstRow.','.$Page->listRows)->select();
		//for template show
        $this->assign("list", $list);
		$this->assign('page',$show);
        $this->display();
    }

    public function add()
    {
		import("@.API.EnumAPI");
        $dropdown_status=EnumAPI::getSelect("ENUM_STATUS","active",$result["active"]);
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
        $Model = D("tag");

        $validate = array(
            array('name', 'require', L('L_MUST_FILL') . L('L_NAME')),
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

        $Model = M("tag");
        $map['id'] = array('eq', $id);
        $result = $Model->where($map)->find();

        if (!$result)
        {
            $this->error(L("L_PARAMETER_ERROR_PLEASE_TRY_AGAIN"));
        }
		
		import("@.API.EnumAPI");
        $dropdown_status=EnumAPI::getSelect("ENUM_STATUS","active",$result["active"]);
		$this->assign("DROPDOWN_STATUS",$dropdown_status);
		
		//current module path
		$current_module_path=array(
			$result,
			array("name"=>"L_EDIT"),
		);
		$this->assign("current_system_object",$current_module_path);
		
        $this->assign("vo", $result);
        $this->display();
    }

    public function update()
    {
        $Model = D("tag");
        $validate = array(
            array('name', 'require', L('L_MUST_FILL') . L('L_NAME')),
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

        $Model = D("tag");
		
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
	
		public function install($moduleinfo,$plugininfo)
	{
		$dbprefix=$moduleinfo['keyword'].'_'.$plugininfo['keyword'].'_';
		$tbname=$dbprefix.'relation';
		//init db
		
		//register on the module
		$moduletable = array(
			'module_keyword'=>$moduleinfo['keyword'],
			'table_name'=>$tbname,
			'forplugin'=>1,
			'note'=>'for Tag plugin',
		);
		
		$mtModule = M('module_table');
		$mtModule->add($moduletable);
		
		$fieldtable = array(
			array('table_name'=>$tbname,'name'=>'ID','field'=>'id','field_type'=>'int','index'=>'1'),
			array('table_name'=>$tbname,'name'=>'Type','field'=>'type','field_type'=>'char50','index'=>'2'),
			array('table_name'=>$tbname,'name'=>'Relation','field'=>'realationid','field_type'=>'int','index'=>'2'),
			array('table_name'=>$tbname,'name'=>'Value','field'=>'value','field_type'=>'int','index'=>'0'),
		);
		
		$fModule = M('module_field');
		foreach($fieldtable as $item)
		{
			$fModule->add($item);
		}
	}
	
	public function uninstall($moduleinfo,$plugininfo)
	{
		$dbprefix=$moduleinfo['keyword'].'_'.$plugininfo['keyword'].'_';
		$tbname=$dbprefix.'relation';
		
		//remove register on the module
		$map['module_keyword'] = array('eq',$moduleinfo['keyword']);
		$map['table_name'] = array('eq',$dbprefix.'relation');
		
		$mtModule = M('module_table');
		$mtModule->where($map)->delete();
		
		$mapfield['table_name'] = array('eq',$tbname);
		
		$fModule = M('module_field');
		$fModule->where($mapfield)->delete();
	}
}

?>