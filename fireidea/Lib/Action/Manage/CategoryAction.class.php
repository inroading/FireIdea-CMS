<?php
class CategoryAction extends ManageAction
{

    public function index()
    {
		//new module
		$Model = M("category_group");
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
        $Module = D("category_group");

        $validate = array(
            array('name', 'require', L('L_MUST_FILL') . L('L_NAME')),
            array('slug', 'require', L('L_MUST_FILL') . L('L_SLUG')),
        );

        $Module->setProperty("_validate", $validate);
        $data = $Module->create();

        if (!$data)
        {
            $this->error($Module->getError());
        }
        else
        {
            if ($Module->add($data))
            {
				$this->assign("jumpUrl", U("index"));
                $this->success(L("L_CREATE_SUCCESS"));
            }
        }
    }

    public function edit()
    {
        $id = parseInt($_GET["id"]);

        $Model = M("category_group");
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

        $Model = D("category_group");
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

        $Module = D("category_group");
		
        if (!$id > 0)
        {
            $this->error(L("L_PARAMETER_ERROR_PLEASE_TRY_AGAIN"));
        }
		$result=$Module->where("id=".$id);
		
        if ($result)
        {
			$Module->delete($id);
			//delete sub category
			$CAT_Model = M("category");
			$map1['category_slug'] = array('eq', $result["slug"]);
			$cat_result = $CAT_Model->where($map1)->delete();
		
            $this->success(L("L_DELETE_SUCCESS"));
        }
        else
        {
            $this->error(L("L_FAILTURE_PLEASE_CONTACT_ADMINISTRATOR_TO_SOLVE"));
        }
    }
	
	public function manage()
	{
		$id = parseInt($_GET["id"]);
		
        $Model = M("category_group");
        $map['id'] = array('eq', $id);
        $result = $Model->where($map)->find();
		
        if (!$result)
        {
            $this->error(L("L_PARAMETER_ERROR_PLEASE_TRY_AGAIN"));
        }
		//get category list
		$CAT_Model = M("category");
        $map1['category_slug'] = array('eq', $result["slug"]);
        $cat_result = $CAT_Model->where($map1)->order("displayorder desc")->select();
		
		load('extend');
		$cat_result=list_to_tree($cat_result, 'id', 'parent', 'item',0);
		
        $this->assign("vo", $result);
		$this->assign("cat", $cat_result);
		
		//current module path
		$current_module_path=array(
			$result,
			array("name"=>"L_CATEGORY_MANAGE"),
		);
		$this->assign("current_system_object",$current_module_path);
		
		
        $this->display();
	}
	
	public function ajax_add()
	{
		import("@.API.EnumAPI");
        $dropdown_status=EnumAPI::getSelect("ENUM_STATUS","active","");
		$this->assign("DROPDOWN_STATUS",$dropdown_status);
		
		$this->assign("groupid_t",$_POST["groupid"]);
		$this->assign("parentid_t",$_POST["parentid"]);
		$this->assign("category_slug_t",$_POST["category_slug"]);
		$this->display();
	}
	
	public function ajax_addnew()
	{
		$Module = D("category");

        $validate = array(
            array('name', 'require', L('L_MUST_FILL') . L('L_NAME')),
            array('slug', 'require', L('L_MUST_FILL') . L('L_SLUG')),
        );

        $Module->setProperty("_validate", $validate);
        $data = $Module->create();

        if (!$data)
        {
            $this->error($Module->getError());
        }
        else
        {
            if ($Module->add($data))
            {
                $this->success(L("L_CREATE_SUCCESS"));
            }
        }
	}
	public function ajax_edit()
	{
		$id = parseInt($_POST["id"]);

        $Model = M("category");
        $map['id'] = array('eq', $id);
        $result = $Model->where($map)->find();
		
        if (!$result)
        {
            $this->error(L("L_PARAMETER_ERROR_PLEASE_TRY_AGAIN"));
        }
		
		import("@.API.EnumAPI");
        $dropdown_status=EnumAPI::getSelect("ENUM_STATUS","active",$result["active"]);
		$this->assign("DROPDOWN_STATUS",$dropdown_status);
		
        $this->assign("vo", $result);
        $this->display();
	}
	public function ajax_update()
	{
		$Module = D("category");

        $validate = array(
            array('name', 'require', L('L_MUST_FILL') . L('L_NAME')),
            array('slug', 'require', L('L_MUST_FILL') . L('L_SLUG')),
        );

        $Module->setProperty("_validate", $validate);
        $data = $Module->create();

        if (!$data)
        {
            $this->error($Module->getError());
        }
        else
        {
            if ($Module->save($data))
            {
                $this->success(L("L_UPDATE_SUCCESS"));
            }
        }
	}
	public function ajax_del()
    {
        $id = parseInt($_GET["id"]);

        $Module = D("category");
		$subtree=$Module->where("parent=".$id)->select();
		if($subtree)
		{
			$this->error(L("L_CANT_DELTE_PARENT_TREE_ITEM"));
		}
        if (!$id > 0)
        {
            $this->error(L("L_PARAMETER_ERROR_PLEASE_TRY_AGAIN"));
        }

        if ($Module->delete($id))
        {
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
			'note'=>'for Category plugin',
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