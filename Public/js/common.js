//string trim section
function allTrim(str) {　　
	return str.replace(/(^\s*)|(\s*$)/g, "");
}

function lTrim(str) {　
	return str.replace(/(^\s*)/g, "");
}

function rTrim(str) {　
	return str.replace(/(\s*$)/g, "");
}

//for the select change next select update
function bindSelectChange($url,$name,$target)
{
	$('#'+$name).change(function(){
	      var selectId = $("#"+$name).find(':selected').val();
	      $.ajax({
	        url:$url , 
	        type:'POST',
	        timeout: 10000,
	        cache: false,
	        data:{id: selectId},
	        success: function(r){
	          if(r){
	            $("#"+$target).html(r);
	          }else{
	            alert('获取列表失败，请检查网络'); 
	          }
	        } 
      	})
  	});
}
//do an operation and wait result msg and state
function requestAction($url, $data, $closeparent) {
	if ($closeparent == true) {
		$.prompt.close();
	}

	$.ajax({
		type: "POST",
		url: $url,
		datatype: "json",
		cache: false,
		data: $data,
		timeout: 10000,
		success: function($return) {
			if ($return.info != undefined && $return.info != '') {
				$.prompt($return.info);
				return 0;
			}
			if ($return.info == undefined || $return.info == '') {
				$.prompt('服务器返回信息为空!');
				return 0;
			}
		}
	});
}

//get html float div code
function requestHtml($url, $data, $closeparent) {
	if ($closeparent == true) {
		$.prompt.close();
	}
	$.ajax({
		type: "POST",
		url: $url,
		cache: false,
		data: $data,
		success: function($html) {
			$.prompt($html);
		}
	});
}

//make the div can scroll by mouse
function scrollDiv(divname) {
	var start_hand = "url(/Public/cur/start_hand.cur),pointer";
	var end_hand = "url(/Public/cur/end_hand.cur),pointer";
	var y = 0;

	$(divname).css({
		"cursor": start_hand
	}).mousedown(function(e) {
		$(this).css("cursor", end_hand).stop(true, false).mousemove(moveDrag);
		y = e.pageY;
		return false;
	}).mouseup(function(e) {
		$(divname).css("cursor", start_hand).unbind("mousemove", moveDrag);
		return true;
	})

	.mouseleave(function(e) {
		$(divname).css("cursor", start_hand).unbind("mousemove", moveDrag);
		return true;
	});

	function moveDrag(e) {
		var pos_y = e.pageY - y;
		$(this).animate({
			scrollTop: "-=" + pos_y * 2
		}, 20);
		y = e.pageY;
		return true;
	}
}

//dump the var function detail 
function varDump(o, depth) {
	var result = '';
	depth || (depth = 1);
	var indent = new Array(4 * depth + 1).join(' ');
	var indentNext = new Array(4 * (depth + 1) + 1).join(' ');
	var indentNextTwo = new Array(4 * (depth + 2) + 1).join(' ');
	var tmp = '';
	var type = typeof o;
	switch (type) {
	case 'string':
	case 'number':
	case 'boolean':
	case 'undefined':
	case 'function':
		tmp += indent + indentNext + o + "\n";
		break;
	case 'object':
	default:
		for (var key in o) {
			tmp += indentNextTwo + '[' + key + '] = ';
			tmp += print_r(o[key], (depth + 1));
		}
	}
	result += type + "\n";
	result += indentNext + '(' + "\n";
	result += tmp;
	result += indentNext + ')' + "\n";
	return result;
};

//choice special value option item for select
function setSelectValue(selname, value) {
	$("[name='" + selname + "']").each(function() {
		if (!value) {
			$(this).removeAttr("checked");
		} else {
			$(this).attr("checked", 'true');
		}
	})
}

//confirm an tips ,if choise true .location the url 
function confirmJump(tips, url) {
	$.prompt(tips, {
		buttons: [{
			title: 'Yes',
			value: true
		}, {
			title: 'No',
			value: false
		}],
		submit: function(v, m, f) {
			if (v == true) {
				window.location = url;
			}
		},
		focus: 1,
	});

}

function locationUrl(url)
{
	location.href = url;
}

$(document).ready(function() {

});

///////////////////////////////////////////////////not finished function
function showfullname(val, obj) {
	var pos = getobj_position(obj);//lost function getobjposition
	$("#fullname_title").html(val);
	$('#fullname').css({
		'left': pos.Left + 'px',
		'top': pos.Top + 20 + 'px'
	});
	$('#fullname').show();
}

function hidefullname() {
	$('#fullname').hide();
}
