<?php
class EnumAPI {
	//获取枚举项列表
    public static function getTypeList($type)
    {
	    $result="";
        $TG_Model=D("enum_group");
		$T_Model=D("enum");
		
		if(S("SYSTEM_ENUM_".$type)==NULL)
		{
			$result=$TG_Model->where("slug  = '".$type."'")->find();
			if($result)
			{
				$result=$T_Model->where("groupid=".$result["id"])->select();
				S("SYSTEM_ENUM_".$type,$result);
				return $result;
			}
			else
			{
				return NULL;
			}
		}
		
		return S("SYSTEM_ENUM_".$type);
    }
	
	public static function getKeywordList($type)
    {
		$key="SYSTEM_ENUM_KEYWORD_".$type;
	    $result="";
		
        $TG_Model=D("enum_group");
		$T_Model=D("enum");
		
		if(S($key)==NULL)
		{
			$result=$TG_Model->where("slug  = '".$type."'")->find();

			if($result)
			{
				$dt=array();
				$result=$T_Model->where("groupid=".$result["id"])->select();
				foreach($result as $r)
				{
					$dt[$r['value']]=$r;
				}
				S($key,$dt);
				return $dt;
			}
			else
			{
				return NULL;
			}
		}
		
		return S($key);
    }
	
	//生成枚举html列表
	public static function getSelect($type,$name,$select_value)
	{
		$typelist=EnumAPI::getTypeList($type);
		return show_select($name,$typelist,"name","value",$select_value);
	}
	//获取枚举对应值
	public static function getName($type,$value)
	{
		$list=EnumAPI::getKeywordList($type);
		if(!empty($list[$value]))
		{
			return $list[$value]['name'];
		}
		else
		{
			return NULL;
		}
	}
}
?>
