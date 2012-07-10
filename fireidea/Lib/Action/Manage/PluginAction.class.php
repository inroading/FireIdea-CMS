<?php
class PluginAction extends ManageAction
{
	function _initialize() {
		parent::_initialize();
    }
	
    public function index()
    {
        $this->display();
    }
	 
	//插件管理
	public function module()
	{
		$id = parseInt($_GET["id"]);
		
		$linkModule = M("plugin_link");
		
		//get module infomation
		$module = M('module');
		$modinfo = $module->find($id);

		if (!$modinfo)
        {
            $this->error(L("L_PARAMETER_ERROR_PLEASE_TRY_AGAIN"));
        }
		
		//get plugin list
        $Model = M("plugin_index");
        $result = $Model->field("pi.id,pi.keyword,pi.name,pi.note,mp.plugin_keyword,mp.module_keyword")->table(C("DB_PREFIX")."plugin_index pi")->join(C("DB_PREFIX")."module_plugin mp on pi.keyword=mp.plugin_keyword and mp.module_keyword='".$modinfo['keyword']."'")->select();

        if (!$result)
        {
            $this->error(L("L_PARAMETER_ERROR_PLEASE_TRY_AGAIN"));
        }
 		//get the plugin manage link
		foreach($result as &$item)
		{
			$item["link"]=$linkModule->where("type='manage' and plugin_keyword='".$item['keyword']."'")->select();
		}
		//current module path
		$current_module_path=array(
			array("name"=>$modinfo['name']),
			array("name"=>"L_PLUGIN_REFRENCE"),
		);
		
		$this->assign("vo", $result);
		$this->assign("modinfo",$modinfo);
		$this->assign("current_system_object",$current_module_path);
		$this->display();
	}
	//install the plugin
	public function pluginstall()
	{
		$id = parseInt($_GET["id"]);
		$mid = parseInt($_GET["module"]);
		//get plugin info
		$Plugin = M("plugin_index");
		$plugininfo=$Plugin->find($id);
		if (!$plugininfo)
        {
            $this->error(L("L_PARAMETER_ERROR_PLEASE_TRY_AGAIN"));
        }
		//get module info
		$Module = M("module");
		$moduleinfo=$Module->find($mid);
		if (!$moduleinfo)
        {
            $this->error(L("L_PARAMETER_ERROR_PLEASE_TRY_AGAIN"));
        }
		
		$Relation = M("module_plugin");
		//make sure not install on this module
		$mp_info = $Relation->where("module_keyword = '".$moduleinfo['keyword']."' and plugin_keyword ='".$plugininfo['keyword']."'")->select();
		
		if($mp_info)
		{
			$this->error(L("L_PARAMETER_ERROR_PLEASE_TRY_AGAIN"));
		}
		//prepare the relation infomation
		$dat=array(
			'module_keyword' => $moduleinfo['keyword'],
			'plugin_keyword' => $plugininfo['keyword'],
		);
		
		//invoke the plugin install function
		try { 
			R('Manage/'.$plugininfo['module'].'/install',array($moduleinfo,$plugininfo));
		} catch (Exception $e) { 
			$this->error(L("L_FAILTURE_PLEASE_CONTACT_ADMINISTRATOR_TO_SOLVE"));
		} 
		//save the install info on the table
		if($Relation->add($dat))
		{
			 $this->success(L("L_UPDATE_SUCCESS"));
		}else
		{
			 $this->error(L("L_FAILTURE_PLEASE_CONTACT_ADMINISTRATOR_TO_SOLVE"));
		}
	}
	//uninstall the plugin
	public function pluguninstall()
	{
		$id = parseInt($_GET["id"]);
		$mid = parseInt($_GET["module"]);
		
		//get plugin info
		$Plugin = M("plugin_index");
		$plugininfo=$Plugin->find($id);
		if (!$plugininfo)
        {
            $this->error(L("L_PARAMETER_ERROR_PLEASE_TRY_AGAIN"));
        }
		
		//get module info
		$Module = M("module");
		$moduleinfo=$Module->find($mid);
		if (!$moduleinfo)
        {
            $this->error(L("L_PARAMETER_ERROR_PLEASE_TRY_AGAIN"));
        }
		
		$Relation = M("module_plugin");
		$map['module_keyword']=array('eq',$moduleinfo['keyword']);
		$map['plugin_keyword']=array('eq',$plugininfo['keyword']);
		
		//make sure not install on this module
		$mp_info = $Relation->where($map)->select();
		
		if(!$mp_info)
		{
			$this->error(L("L_PARAMETER_ERROR_PLEASE_TRY_AGAIN"));
		}
 
		//invoke the plugin install function
		try { 
			R('Manage/'.$plugininfo['module'].'/uninstall',array($moduleinfo,$plugininfo));
		} catch (Exception $e) { 
			$this->error(L("L_FAILTURE_PLEASE_CONTACT_ADMINISTRATOR_TO_SOLVE"));
		} 
		//save the install info on the table
		if($Relation->where($map)->delete())
		{
			 $this->success(L("L_DELETE_SUCCESS"));
		}else
		{
			 $this->error(L("L_FAILTURE_PLEASE_CONTACT_ADMINISTRATOR_TO_SOLVE"));
		}
	}
}
?>