function trim(str){
　　 return str.replace(/(^\s*)|(\s*$)/g, "");
}
function ltrim(str){
　  return str.replace(/(^\s*)/g,"");
}
function rtrim(str){
　  return str.replace(/(\s*$)/g,"");
}


function requesthtml($url,$data,$closeparent)
{
	if($closeparent==true)
	{
		$.prompt.close();
	}
	$.ajax({type: "POST",url: $url,cache:false,data:$data,
	   success: function(html){	   
		get_return(html);
	   }	   
	 });
}

function get_return($msg)
{	
	if($msg == undefined || $msg=='')
	{
		$.prompt('服务器返回空!');
		return 0;
	}
	str=$msg;
	try{
            $return =  eval('(' + str + ')');
			if($return.status!="0" && $return.status!="1")
			{
				 $.prompt($msg);		 
				 return 0;
			}
    }catch(ex){
		//may be is html
		    type="html"
            $.prompt($msg,{buttons: { }});
			return 0;
    }
	
	if ($return.info!= undefined && $return.info!=''){
		$.prompt($return.info);
		return 0;
	}
	if($return.info== undefined || $return.info=='')
	{
		$.prompt('服务器返回信息为空!');
		return 0;
	}
}

function bind_scrol_by_mouse(divname)
{
    var start_hand = "url(__PUBLIC__/cur/start_hand.cur),pointer";  
    var end_hand = "url(__PUBLIC__/cur/end_hand.cur),pointer";
    var y = 0;

    $(divname).css({"cursor":start_hand})
        .mousedown(function(e){
            $(this).css("cursor", end_hand).stop(true, false).mousemove(moveDrag);
            y = e.pageY;
            return false;
        })
        .mouseup(function(e){
            $(divname).css("cursor", start_hand).unbind("mousemove",moveDrag);
            return true;
            })
        
        .mouseleave(function(e){
            $(divname).css("cursor", start_hand).unbind("mousemove",moveDrag);
            return true;
            });     
    
    function moveDrag(e){
        var pos_y = e.pageY - y;
        $(this).animate({scrollTop : "-="+pos_y*2},20);
        y = e.pageY;
        return true;
    }
}

function print_r(o, depth) {
	  var result = '';
	  depth || (depth=1);
	  var indent = new Array(4*depth+1).join(' ');
	  var indentNext = new Array(4*(depth+1)+1).join(' ');
	  var indentNextTwo = new Array(4*(depth+2)+1).join(' ');
	  var tmp = '';
	  var type = typeof o;
	  switch(type) {
		case 'string':
		case 'number':
		case 'boolean':
		case 'undefined':
		case 'function':
		  tmp += indent + indentNext + o + "\n";
		  break;
		case 'object':
		default:
		  for(var key in o) {
			tmp += indentNextTwo + '[' + key + '] = ';
			tmp += print_r(o[key], (depth+1));
		  }
	  }
	  result += type + "\n";
	  result += indentNext + '(' + "\n";
	  result += tmp;
	  result += indentNext + ')' + "\n";
	  return result;
};

function bindSelectValue(elname, value)
{
	$("[name='"+elname+"']").each(function(){
		if(!value)
		{
			$(this).removeAttr("checked");
		}
		else
		{
			$(this).attr("checked",'true');
		}
	})
}

function showfullname(val,obj)
{
    var pos=getobj_position(obj);
    $("#fullname_title").html(val);
    $('#fullname').css({'left':  pos.Left+ 'px', 'top':  pos.Top+20+'px'});
    $('#fullname').show();
}

function hidefullname()
{
    $('#fullname').hide();
}

function confim_del(tips,url)
{
	$.prompt(tips,{
		buttons:[
			{title: 'Yes',value:true},
			{title: 'No',value:false}
		], 
		submit: function(v,m,f){ 
		   if(v==true)
		   {
		    window.location=url; 
		   }
		} 
		, focus: 1
	});

}
$(document).ready(function(){

});
