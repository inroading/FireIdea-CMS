<?php
//友好显示日期
function getFriendDataTime($val)
{
    $n_time = time();
    $d_time = strtotime($val);
    $x_time = ($n_time - $d_time) / 3600 * 60;
    if ($x_time > 60)
    {
        $x_time = ($n_time - $d_time) / 3600;
        if ($x_time > 24)
        {
            if ($x_time < 240)
            {
                $x_time = $x_time / 24;
                $s_time = (int) $x_time . L('DAYS_AGO');
            }
            else
            {
                $s_time = date('m-d', $d_time);
            }
        }
        else
        {
            $s_time = (int) $x_time . L('HOURS_AGO');
        }
    }
    else
    {
        $s_time = (int) $x_time . L('MINUTES_AGO');
    }
    return $s_time;
}

//秒转换成24小时格式
function second2time($sec)
{
    $second = (int) ($sec % 60);
    $minute = intval(($sec % 3600) / 60);
    $hour = (int) ($sec / 3600);
    return fill_zero($hour, 2) . ":" . fill_zero($minute, 2) . ":" . fill_zero($second, 2);
}

function time2second($timestr)
{
    $time_str = explode(":", $timestr);
    return intval($time_str[0]) * 3600 + intval($time_str[1]) * 60 + intval($time_str[2]);
}

//xml动态创建函数
function xml_addChild($dom, $innode, $nodename, $value=NULL, $cdata=false)
{
    if ($value != NULL)
    {
        $node = $dom->createElement($nodename);
        if ($cdata)
        {
            $text = $dom->createCDATASection($value);
        }
        else
        {
            $text = $dom->createTextNode($value);
        }
        $node->appendChild($text);
    }
    else
    {
        $node = $dom->createElement($nodename);
    }
    $innode->appendChild($node);
    return $node;
}

function xml_addattr($dom, $innode, $attrname, $value)
{
    $text = $dom->createTextNode($value);
    $attr = $dom->createAttribute($attrname);
    $attr->appendChild($text);
    $innode->appendChild($attr);
}

//对参数进行转义用
function base64UrlEncode($str)
{
    $pattern = array('0' => '00', '+' => '01', '/' => '02', '=' => '03',);
    $str = base64_encode($str);
    return strtr($str, $pattern);
}

//和上面配套使用
function base64UrlDecode($str)
{
    $pattern = array('0' => '00', '+' => '01', '/' => '02', '=' => '03',);
    $str = strtr($str, array_flip($pattern));
    return base64_decode($str);
}

//字符串只返回数值部分
function parseInt($string)
{
    if (preg_match('/(\d+)/', $string, $array))
    {
        return $array[1];
    }
    else
    {
        return 0;
    }
}

//输出重复前置符号
function echoIndentString($level, $str = "├ ─ ─")
{   
    return str_repeat('&nbsp;&nbsp;&nbsp;',$level*3).$str;
}

//获取树形节点
function getArrayTreePath($url, $baseurl="fileselect")
{
    $result = $url;
    $endindex = 0;

    $urllist = array();

    while ($local = strpos($result, "/"))
    {
        $upindex = $endindex;

        $result = substr($result, $local + 1);
        $endindex+= ( $local + 1);

        $tmp["url"] = substr($url, 0, $endindex);
        $tmp["en_url"] = U($baseurl . "?u=" . base64_encode($tmp["url"]));
        $tmp["name"] = substr($url, $upindex, $local + 1);

        array_push($urllist, $tmp);
    }

    return $urllist;
}

//清空某个目录内所有文件
function delDirTree($dir)
{
    if (!($handle = opendir($dir)))
    {
        return;
    }
    while (false !== ($file = readdir($handle)))
    {
        if ($file !== "." && $file !== "..")
        {
            $file = $dir . DIRECTORY_SEPARATOR . $file;
            if (is_dir($file))
            {
                delDirTree($file);
            }
            else
            {
                @unlink($file);
            }
        }
        @rmdir($dir);
    }
}

//图像显示函数，自动显示缩略图，如果没有缩略图显示源文件，如果没有源文件显示暂无图片
function showImage($path, $prefix='', $fourtothree=false)
{
	$nopic = __ROOT__ . "/Public/images/nopic.gif";
    if ($path)
    {
        $filename = basename($path);
        $filepath = substr($path, 0, strpos($path, $filename));

        if ($prefix != '')
        {
            if (file_exists(APP_PATH . $filepath . $prefix . $filename))
            {
                return __ROOT__ . $filepath . $prefix . $filename;
            }
            else
            {
                return $nopic;
            }
        }

        if (file_exists(APP_PATH . $filepath . $filename))
        {
            return __ROOT__ . $filepath . $filename;
        }
        else
        {
            return $nopic;
        }
    }
    else
    {
        return $nopic;
    }
}
//curl 方式发送post请求
function postData($data_arr, $host, $port, $url, &$output)
{
    $postdata = '';
    foreach (array_keys($data_arr) as $key)
    {
        $postdata = $postdata . rawurlencode($key) . "=" . rawurlencode($data_arr[$key]) . "&";
    }
    $postdata = substr($postdata, 0, strlen($postdata) - 1);
    $ch = curl_init($host . ":" . $port . "/" . $url);

    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $postdata);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Expect:'));
    curl_setopt($ch, CURLOPT_TIMEOUT, 5);
    $data = curl_exec($ch);
    curl_close($ch);

    if ($data)
    {
        $output = $data;
        return TRUE;
    }
    else
    {
        return FALSE;
    }
}

//生成唯一GUID用于生成唯一标示用
function getGuid()
{
    $tmp = gettimeofday();
    $tmp = $tmp["sec"] . "-" . $tmp["usec"] . "-" . $tmp["minuteswest"];
    return md5($tmp . rand());
}

//获取当前系统最大可上传文件大小
function getMaxUploadFileSize()
{
    $POST_MAX_SIZE = ini_get('post_max_size');
    $mul = substr($POST_MAX_SIZE, -1);
    $mul = ($mul == 'M' ? 1048576 : ($mul == 'K' ? 1024 : ($mul == 'G' ? 1073741824 : 1)));
    $POST_MAX_SIZE = $mul * (int) $POST_MAX_SIZE;

    $POST_MAX_SIZE_U = ini_get('upload_max_size');

    $mul_U = substr($POST_MAX_SIZE_U, -1);
    $mul_U = ($mul_U == 'M' ? 1048576 : ($mul_U == 'K' ? 1024 : ($mul_U == 'G' ? 1073741824 : 1)));
    $POST_MAX_SIZE_U = $mul_U * (int) $POST_MAX_SIZE_U;

    if ($POST_MAX_SIZE_U == "")
    {
        $POST_MAX_SIZE_U = $POST_MAX_SIZE;
    }

    if ($POST_MAX_SIZE < $POST_MAX_SIZE_U)
    {
        return $POST_MAX_SIZE;
    }
    else
    {
        return $POST_MAX_SIZE_U;
    }
}

//GD图形处理库插件工作状态获取
function getGDStatus()
{
    if (extension_loaded("gd"))
    {
        if (function_exists("gd_info"))
        {
            return L("ADMIN_HOME_GD_OK");
        }
        else
        {
            echo L("ADMIN_HOME_GD_OLD");
        }
    }
    else
    {
        echo L("ADMIN_HOME_GD_NONE");
    }
}
//根据数据生成下拉列表
function getSelectHtml($id, $data, $key, $value, $select_value, $show_empty="", $show_empty_val="")
{
    $result = "<select id='" . $id . "' name='" . $id . "'>";
    if ($show_empty != "")
    {
        $result = $result . "<option value='" . $show_empty_val . "' >" . $show_empty . "</option>";
    }
    if (is_array($data))
    {
        foreach ($data as $item)
        {
            if ($select_value != "" && $item[$value] == $select_value)
            {
                $result = $result . "<option value='" . $item[$value] . "' selected='selected' >" . L($item[$key]) . "</option>";
            }
            else
            {
                $result = $result . "<option value='" . $item[$value] . "' >" . L($item[$key]) . "</option>";
            }
        }
    }
    else if ($show_empty == "")
    {
        $result = $result . "<option value='' selected='selected' >".L("L_NONE")."</option>";
    }
    $result = $result . "</select>";
    return $result;
}

//show select list tree
function getSelectTreeHtml($data, $key, $value, $deep, $select_value, $show_empty="", $show_empty_val="")
{
    if ($show_empty != "")
    {
        $result = "<option value='" . $show_empty_val . "' selected='selected' >" . $show_empty . "</option>\r\n";
    }
    foreach ($data as $item)
    {
        if ($item[$value] == $select_value)
        {
            $result = $result . "<option value='" . $item[$value] . "' selected='selected' >" . echoIndentString($deep) . " " . $item[$key] . "</option>\r\n";
        }
        else
        {
            $result = $result . "<option value='" . $item[$value] . "'  >" . echoIndentString($deep) . " " . $item[$key] . "</option>\r\n";
        }
        if ($item["_child"])
        {
            $result = $result . getSelectTreeHtml($item["_child"], $key, $value, $deep+1, $select_value);
        }
    }
    return $result;
}
//自动填零
function fillNumberZero($val, $len)
{
    if (strlen($val) < $len)
    {
        for ($i = 0; $i < ($len - strlen($val)); $i++)
        {
            $val = "0" . $val;
        }
    }
    return $val;
}

//过长标题自动缩短
function cutTitleString($title, $length=20)
{
    $title = h($title);
    if (strlen($title) > $length)
    {
        return "<span onmouseover='showfullname(\"" . $title . "\",this)'>" . msubstr($title, 0, $length) . "...</span>";
    }
    else
    {
        return "<span>" . $title . "</span>";
    }
}
//text filter
function filterString($string)
{
	if(!get_magic_quotes_gpc() ) {
		if(is_array($string)) {
			foreach($string as $key => $val) {
			$string[$key] = daddslashes($val, $force);
		}
		} else {
			$string = addslashes($string);
		}
	}
	return $string;
}

//recursive for html tree
function treeRecursive($data,$template,$childtag,$htmltagarray,$keyarray,$level=0)
{
	foreach($data as $dt)
	{
		$outhtml=$template;
		//prepare the result for replace use
		$replaced_array=array();
		foreach($keyarray as $ha)
		{
			array_push($replaced_array,$dt[$ha]);
		}
		
		//render the html
		$outhtml=str_replace($htmltagarray,$replaced_array,$outhtml);
		
		//render the level
		$outhtml=str_replace("%%level_deep%%",$level,$outhtml);
		$outhtml=str_replace("%%level_intend%%",echoIndentString($level),$outhtml);
		echo $outhtml;
		
		if(isset($dt[$childtag]) && is_array($dt[$childtag]))
		{
			treeRecursive($dt[$childtag],$template,$childtag,$htmltagarray,$keyarray,$level+1);
		}
	}
}

//递归算出树路径元素
function getTreeNodePath($menu,$itemtag,$compareval)
{
	$return=array();
	foreach($menu as $m)
	{
		if(isset($m[$itemtag]) && is_array($m[$itemtag]))
		{
			$result=getTreeNodePath($m[$itemtag]);
			if($result!=null)
			{
				array_push($result,$m);
				return $result;
			}
		}
		//decide if is we want item
		$foundflag=true;
		foreach($compareval as $cpt=>$val)
		{
			if($m[$cpt]!=$val)
			{
				$foundflag=false;
			}
		}
		if($foundflag)
		{
			return array($m);
		}
	}
	return null;
}
//transform the array with special key for array key
function arrangeArrayByKey($input,$key)
{
    $result = array();
    foreach ($input as $value) {
        $result[$value[$key]]=$value;
    }
    return $result;
}

//发送邮件
function SendMail($address,$title,$message)
{
    vendor('PHPMailer.class#PHPMailer');

    $mail=new PHPMailer();
	switch(C("MAIL_TYPE"))
	{
		case "php":
			$mail->IsMail();
			break;
		case "sendmail":
			$mail->IsSendmail();
			break;
		case "smtp":
			$mail->IsSMTP();
			$mail->Host=C('MAIL_HOST');
			$mail->Port=C('MAIL_PORT');
			//if can auth
			$mail->SMTPAuth=true;
    		$mail->Username=C('MAIL_LOGINNAME');
    		$mail->Password=C('MAIL_PASSWORD');
			//gmail
			$mail->SMTPSecure =C('MAIL_SECURE');// gmail is "tls"; 
			break;
		case "qmail":
			$mail->IsQmail();
			break;
	}

    $mail->CharSet='UTF-8';
    $mail->SetFrom(C('MAIL_ADDRESS'), C('MAIL_SENDERNAME'));

	if(is_array($address))
	{
		foreach($address as $addressitem)
		{
    		$mail->AddAddress($addressitem);
		}
	}else
	{
		$mail->AddAddress($address);
	}
	
	$message = preg_replace('/[\\]/i','',$message);
	
	$mail->Subject = $title;
	$mail->MsgHTML($message);
	$mail->AltBody = "To view the message, please use an HTML compatible email viewer!"; 
    // optional, comment out and test
	$mail->Priority=1;
	
    return $mail->Send();
}

?>