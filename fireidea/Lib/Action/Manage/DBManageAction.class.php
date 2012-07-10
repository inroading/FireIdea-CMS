<?php
class DBManageAction extends ManageAction
{
	//数据库结构管理界面
    public function module()
    {
        $id = parseInt($_GET["id"]);

        $Model = M("module");
        $map['id'] = array('eq', $id);
        $result = $Model->where($map)->find();

        if (!$result)
        {
            $this->error(L("L_PARAMETER_ERROR_PLEASE_TRY_AGAIN"));
        }

        //get module table list
		$tbl_list=$Model->table(C("db_prefix")."module_table")->where("module_keyword='".$result["keyword"]."'")->order("id asc")->select();
		
		//get table field list
		foreach($tbl_list as &$tbitem)
		{
			$tbitem["fields"]=$Model->table(C("db_prefix")."module_field")->where("table_name='".$tbitem["table_name"]."'")->order("id asc")->select();
		}
		
		//current module path
		$current_module_path=array(
			$result,
			array("name"=>"L_MODULE_DB_MANAGE"),
		);
		
		$this->assign("vo", $result);
		$this->assign("tblist", $tbl_list);
		$this->assign("current_system_object",$current_module_path);
        $this->display();
    }
	//插入表字段界面
	public function addfield()
	{
		$table_name = FP($_POST["table_name"]);
		$this->assign("table_name",$table_name);
		
		import("@.API.EnumAPI");
        $dropdown=EnumAPI::getSelect("ENUM_DBFIELDTYPE","field_type","");
		$this->assign("ENUM_DBFIELDTYPE",$dropdown);
		
		$dropdown=EnumAPI::getSelect("ENUM_DBINDEXTYPE","index","");
		$this->assign("ENUM_DBINDEXTYPE",$dropdown);
		
		$this->display();
	}
	//插入表字段
	public function insertfield()
	{
		$Model=M("module_field");
		
		$validate = array(
			array('name', 'require', L('L_MUST_FILL') . L('L_DISPLAYNAME')),
            array('table_name', 'require', L('L_MUST_FILL') . L('L_TABLENAME')),
			array('field', 'require', L('L_MUST_FILL') . L('L_FIELDNAME')),
        );
		$Model->setProperty("_validate", $validate);
        $result = $Model->create();

        if (!$result)
        {
            $this->error($Model->getError());
        }
        else
        {
			//if have index
			if($_POST["index"]!="none")
			{
				if($_POST['index']=="unique")
				{
					$result["unique_index"]=1;
				}
				if($_POST['index']=="index")
				{
					$result["have_index"]=1;
				}
			}
		
            $Model->add($result);
            $this->success(L("L_CREATE_SUCCESS"));
        }
	}
	//修改表字段界面
	public function editfield()
	{
		$id=parseInt($_POST['id']);
		$Model=M('module_field');
		
		$map['id'] = array('eq', $id);
        $result = $Model->where($map)->find();

        if (!$result)
        {
            $this->error(L("L_PARAMETER_ERROR_PLEASE_TRY_AGAIN"));
        }
		
		import("@.API.EnumAPI");
        $dropdown=EnumAPI::getSelect("ENUM_DBFIELDTYPE","field_type",$result['field_type']);
		$this->assign("ENUM_DBFIELDTYPE",$dropdown);
		
		$dropdown=EnumAPI::getSelect("ENUM_DBINDEXTYPE","index",$result['index']);
		$this->assign("ENUM_DBINDEXTYPE",$dropdown);
		
		$this->assign("vo", $result);
		$this->display();
	}
	//更新表字段
	public function updatefield()
	{
		$Model = M("module_field");
		$validate = array(
			array('name', 'require', L('L_MUST_FILL') . L('L_DISPLAYNAME')),
            array('table_name', 'require', L('L_MUST_FILL') . L('L_TABLENAME')),
			array('field', 'require', L('L_MUST_FILL') . L('L_FIELDNAME')),
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
	//删除表字段
	public function delfield()
    {
        $id = parseInt($_GET["id"]);

        $Model = D("module_field");

        if (!$id > 0)
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
	//创建表界面
	public function addtable()
	{
		$this->assign("module_keyword",$_POST['module_keyword']);
		$this->display();
	}
	//创建表
	public function createtable()
	{
		$Model=M("module_table");
		
		$validate = array(
			array('table_name', 'require', L('L_MUST_FILL') . L('L_TABLENAME')),
			array('module_keyword', 'require', L('L_MUST_FILL') . "module_keyword"),
        );
		$Model->setProperty("_validate", $validate);
        $result = $Model->create();

        if (!$result)
        {
            $this->error($Model->getError());
        }
        else
        {
			//create PK
			$fieldresult=array(
				'table_name'=>FP($_POST['table_name']),
				'name'=>'id',
				'field'=>'id',
				'field_type'=>'int',
				'systemfixed'=>1,
				);
			M("module_field")->add($fieldresult);
			
            $Model->add($result);
            $this->success(L("L_CREATE_SUCCESS"));
        }
	}
	//删除表
	public function deltable()
    {
        $id = parseInt($_GET["id"]);

        $Model = D("module_table");
		
		$map['id'] = array('eq', $id);
        $result = $Model->where($map)->find();
		
        if (!$result)
        {
            $this->error(L("L_PARAMETER_ERROR_PLEASE_TRY_AGAIN"));
        }

        if ($Model->delete($id))
        {
			$fieldModel = D("module_field");
			$fieldmap['table_name'] = array('eq', $result['table_name']);
			$fieldModel->where($fieldmap)->delete();
			
            $this->success(L("L_DELETE_SUCCESS"));
        }
        else
        {
            $this->error(L("L_FAILTURE_PLEASE_CONTACT_ADMINISTRATOR_TO_SOLVE"));
        }
    } 
}
?>