var regexEnum = 
{
	intege:"^-?[1-9]\\d*$",					//整数
	intege1:"^[1-9]\\d*$",					//正整数
	intege2:"^-[1-9]\\d*$",					//负整数
	num:"^([+-]?)\\d*\\.?\\d+$",			//数字
	num1:"^[1-9]\\d*|0$",					//正数（正整数 + 0）
	num2:"^-[1-9]\\d*|0$",					//负数（负整数 + 0）
	decmal:"^([+-]?)\\d*\\.\\d+$",			//浮点数
	decmal1:"^[1-9]\\d*.\\d*|0.\\d*[1-9]\\d*$",　　	//正浮点数
	decmal2:"^-([1-9]\\d*.\\d*|0.\\d*[1-9]\\d*)$",　 //负浮点数
	decmal3:"^-?([1-9]\\d*.\\d*|0.\\d*[1-9]\\d*|0?.0+|0)$",　 //浮点数
	decmal4:"^[1-9]\\d*.\\d*|0.\\d*[1-9]\\d*|0?.0+|0$",　　 //非负浮点数（正浮点数 + 0）
	decmal5:"^(-([1-9]\\d*.\\d*|0.\\d*[1-9]\\d*))|0?.0+|0$",　　//非正浮点数（负浮点数 + 0）

	email:"^\\w+((-\\w+)|(\\.\\w+))*\\@[A-Za-z0-9]+((\\.|-)[A-Za-z0-9]+)*\\.[A-Za-z0-9]+$", //邮件
	color:"^[a-fA-F0-9]{6}$",				//颜色
	url:"^http[s]?:\\/\\/([\\w-]+\\.)+[\\w-]+([\\w-./?%&=]*)?$",	//url
	chinese:"^[\\u4E00-\\u9FA5\\uF900-\\uFA2D]+$",					//仅中文
	ascii:"^[\\x00-\\xFF]+$",				//仅ACSII字符
	zipcode:"^\\d{6}$",						//邮编
	mobile:"^(13|15)[0-9]{9}$",				//手机
	ip4:"^(25[0-5]|2[0-4]\\d|[0-1]\\d{2}|[1-9]?\\d)\\.(25[0-5]|2[0-4]\\d|[0-1]\\d{2}|[1-9]?\\d)\\.(25[0-5]|2[0-4]\\d|[0-1]\\d{2}|[1-9]?\\d)\\.(25[0-5]|2[0-4]\\d|[0-1]\\d{2}|[1-9]?\\d)$",	//ip地址
	notempty:"^\\S+$",						//非空
	picture:"(.*)\\.(jpg|bmp|gif|jpeg|tif|png|tga)$",	//图片
	rar:"(.*)\\.(rar|zip|7zip|tgz)$",								//压缩文件
	date:"^\\d{4}(\\-|\\/|\.)\\d{1,2}\\1\\d{1,2}$",					//日期
	qq:"^[1-9]*[1-9][0-9]*$",				//QQ号码
	tel:"^(([0\\+]\\d{2,3}-)?(0\\d{2,3})-)?(\\d{7,8})(-(\\d{3,}))?$",	//电话号码的函数(包括验证国内区号,国际区号,分机号)
	username:"^\\w+$",						//用来用户注册。匹配由数字、26个英文字母或者下划线组成的字符串
	letter:"^[A-Za-z]+$",					//字母
	letter_u:"^[A-Z]+$",					//大写字母
	letter_l:"^[a-z]+$",					//小写字母
	idcard:"^[1-9]([0-9]{14}|[0-9]{17})$"	//身份证
}

function doValidate(obj)
{
	var types=$(obj).attr("vtype");//pattern values
	var tips=$(obj).attr("tips");;//tips
	var str=$(obj).attr("value");;//tips
	if (!types) {return};
	types=types.split("|"); //字符分割
	tips=tips.split("|");
	     
	for (i=0;i<types.length ;i++ )   
    {   
		if(allTrim(types[i])=="")continue;
		if(types[i]=="notempty")
		{
			if(allTrim(str)=="")
			{
				$(obj).parent().parent().addClass("error");
				$(obj).parent().parent().removeClass("success");
				$(obj).next().html("<i class='icon-exclamation-sign'></i> "+tips[i]);
				return;
			}
		}else
		{
			parrten=new RegExp(regexEnum[types[i]]);
			
			if(parrten.exec(str)==null)
			{
				$(obj).parent().parent().addClass("error");
				$(obj).parent().parent().removeClass("success");
				$(obj).next().html("<i class='icon-exclamation-sign'></i> "+tips[i]);
				return;
			}
			
			parrten=null;
		}
    } 
	//passed
	$(obj).parent().parent().removeClass("error");
	$(obj).parent().parent().addClass("success");
	$(obj).next().html("<i class='icon-ok'></i>");
}

function isDateTime(str)
{
	var reg = /^(\d{1,4})(-|\/)(\d{1,2})\2(\d{1,2}) (\d{1,2}):(\d{1,2}):(\d{1,2})$/; 
	var r = str.match(reg); 
	if(r==null) return false; 
	var d= new Date(r[1], r[3]-1,r[4],r[5],r[6],r[7]); 
	return (d.getFullYear()==r[1]&&(d.getMonth()+1)==r[3]&&d.getDate()==r[4]&&d.getHours()==r[5]&&d.getMinutes()==r[6]&&d.getSeconds()==r[7]);
}

//校验登录名：只能输入5-20个以字母开头、可带数字、“_”、“.”的字串
function isRegisterUserName(s)
{
	var patrn=/^[a-zA-Z]{1}([a-zA-Z0-9]|[._]){4,19}$/;
	if (!patrn.exec(s)) return false
	return true
}

//校验用户姓名：只能输入1-30个以字母开头的字串
function isTrueName(s)
{
	var patrn=/^[a-zA-Z]{1,30}$/;
	if (!patrn.exec(s)) return false
	return true
}

//校验密码：只能输入6-20个字母、数字、下划线
function isPasswd(s)
{
	var patrn=/^(\w){6,20}$/;
	if (!patrn.exec(s)) return false
	return true
}

$(document).ready(function(){
	$("input:text").each(function(index, element) {
        if($(element).attr("vtype")!="")
		{
			doValidate(element);
		}
    });
});