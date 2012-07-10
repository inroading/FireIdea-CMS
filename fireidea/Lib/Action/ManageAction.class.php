<?php

class ManageAction extends BaseAction {

    public $current_module = "";
    public $current_action = "";
	
	function _initialize() {
		parent::_initialize();
		
		//获取当前模块名称及动作名称
		$this->current_module=MODULE_NAME;
		$this->current_action=ACTION_NAME;
		
		//渲染菜单
		$this->menu_switch();
    }
	
	//获取菜单树形结构
	protected function get_admin_menu()
	{
		if(S("CACHE_SYSTEM_ADMIN_MENU")==NULL)
		{
			load('extend');
			$Model=M("menu");
			$adminmenu=$Model->select();
			$adminmenu=list_to_tree($adminmenu, $pk='shortkey',$pid = 'parent',$child = 'item',$root="");
			
			S("CACHE_SYSTEM_ADMIN_MENU",$adminmenu);
		}
		return S("CACHE_SYSTEM_ADMIN_MENU");
	}
	
	//获取当前模块所属ctype，以此确认属于哪个栏目
	protected function get_parent_module($menu)
	{
		$return=array();
		foreach($menu as $m)
		{
			if(isset($m["item"]) && is_array($m["item"]))
			{
				$result=$this->get_parent_module($m["item"]);
				if($result!=null)
				{
					$currentpath=array('module'=>$m["module"],'action'=>$m["action"],'name'=>$m["name"]);
					array_push($result,$currentpath);
					return $result;
				}
			}
			if($m["module"]==$this->current_module )
			{
				return array(array('module'=>$m["module"],'action'=>$m["action"],'name'=>$m["name"]));
			}
		}
		return null;
	}
	//寻找当前菜单路径树
    protected function menu_switch()
    {
		//获取当前菜单
		$adminmenu=$this->get_admin_menu();
		//当前路径数组
		$admin_breadpath=array();
		//获取当前后台栏目
		$admin_breadpath=array_reverse( $this->get_parent_module($adminmenu));

		//获取当前栏目
		$current_parent=reset($admin_breadpath);
		
		//获取当前功能模块信息
		$current_module=end($admin_breadpath);

		//检测当前页面从属菜单
		foreach($adminmenu as $am)
		{
			//找到父菜单
			if($am["module"]==$current_parent["module"])
			{
				//显示左侧菜单
				$left_menu=$am["item"];
				foreach($left_menu as &$lm)
				{
					foreach($lm["item"] as &$lmi)
					{
						if($lmi["module"]==$this->current_module  )
						{
							$lmi["active"]="active";
						}
					}
				}
				break;
			}
		}
		
		//赋值给模板
		$this->assign("current_module",$current_parent);
		$this->assign("admin_menu",$adminmenu);
		$this->assign("admin_left_menu",$left_menu);
		$this->assign("admin_breadpath",$admin_breadpath);
    }
	//权限管理，未开发
    protected function do_permission_check($per_slug = '') {
        if (!isset($_SESSION['user_id']) || !isset($_SESSION['user_info'])) {
            session_destroy();
            header("location:".U('User/login'));
            exit;
        }
        $user = $_SESSION['user_info'];

        if ($user['user_account'] == C('RESERVED_ADMIN_NAME') || !$per_slug) {
            return TRUE;
        }

        if (!isset($_SESSION['user_permission'])) {
            $this->error(L('ERR_USER_PERMISSION_DENIED'));
        }

        import("@.Util.PermissionUtil");
        $permission = PermissionUtil::get_permission_by_slug($per_slug);

        if (!$permission) {
            $this->error(L('ERR_USER_PERMISSION_DENIED'));
        }

        /* check permission */
        $per_map = $_SESSION['user_permission'];

        if (!testBitmap($per_map, $permission - 1)) {
            $this->error(L('ERR_USER_PERMISSION_DENIED'));
        }

        return TRUE;
    }

}
?>
