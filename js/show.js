var xmlHttp
function GetXmlHttpObject()
{ 
	var objXMLHttp=null
	if (window.XMLHttpRequest)
	{
		objXMLHttp=new XMLHttpRequest()
	}
	else if (window.ActiveXObject)
	{
		objXMLHttp=new ActiveXObject("Microsoft.XMLHTTP")
	}
	return objXMLHttp
}

function msgAjax(kind,x,v)
{ 
	xmlHttp=GetXmlHttpObject()
	if (xmlHttp==null)
	{
		alert ("您的浏览器不支持AJAX！")
		return false
	} 
	if(kind=='change'){
		var url="messageSave.php?action="+kind+"&sort="+x+"&code="+v;
		xmlHttp.onreadystatechange=stateChanged2
	}else{
		var url="messageSave.php?action="+kind+"&x="+x;
		xmlHttp.onreadystatechange=stateChanged
	}
	url=url+"&sid="+Math.random()
	xmlHttp.open("GET",url,true)
	xmlHttp.send(null)
}

function stateChanged() 
{ 
	if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete")
	{
		var rs=xmlHttp.responseText;
		var arr=new Array();
		var arr=rs.split(',');
		switch(arr[0])
		{
			case 'readpass' :
				document.getElementById('read'+arr[1]).innerHTML="<font color='#009900'>已阅读</font>";
				alert('操作成功');break;
			case 'readfail' :
				location.reload();alert('操作失败');break;
			case 'donepass' :
				document.getElementById('done'+arr[1]).innerHTML="<font color='#009900'>已解决</font>";
				document.getElementById('reply'+arr[1]).style.display='none';
				alert('操作成功');break;
			case 'donefail' :
				location.reload();alert('操作失败');break;
			case 'checkpass' :
				msgcode=true;
				document.getElementById('msgcode').innerHTML='';
				break;
			case 'checkfail' :
				msgcode=false;
				document.getElementById('msgcode').innerHTML="<font class='msgcolor1'>验证码不正确</font>";
				break;
		}
	}
}

function stateChanged2() 
{ 
	if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete")
	{
		var rs=xmlHttp.responseText;
		var arr=new Array();
		var arr=rs.split('|||');
		switch(arr[0])
		{
			case 'sort1' :
				if(arr[1]=='null'){
					document.getElementById("msguser2").innerHTML="&nbsp;<select name='replyuserid2'><option value='0'>请选择</option></select>";
					document.getElementById("tr3").className='display1';
				}else{
					document.getElementById("tr3").className='display2';
					document.getElementById("msguser2").innerHTML=arr[1];
				}break;
			case 'sort2' :
				if(arr[1]=='null'){
					document.getElementById("msguser3").innerHTML="&nbsp;<select name='replyuserid3'><option value='0'>请选择</option></select>";
					document.getElementById("tr5").className='display1';
					document.getElementById("tr6").className='display1';
				}else{
					document.getElementById("tr5").className='display2';
					document.getElementById("tr6").className='display1';
					document.getElementById("msggongchang").innerHTML=arr[1];
				}break;
			case 'sort3' :
				if(arr[1]=='null'){
					document.getElementById("msguser3").innerHTML="&nbsp;<select name='replyuserid3'><option value='0'>请选择</option></select>";
					document.getElementById("tr6").className='display1';
				}else{
					document.getElementById("tr6").className='display2';
					document.getElementById("msguser3").innerHTML=arr[1];
				}break;
		}
	}
}
function showAjax(kind,v)
{ 
	var url;
	if(kind == 1){ 
		var flag = document.getElementById('flag').value;
		if(flag > 40){ return false;}
		url = 'adminusersave.php';
	}else if(kind == 2){ url = 'case_adminsave.php';}
	url = url + '?action=show&value='+v;
	
	xmlHttp=GetXmlHttpObject()
	if (xmlHttp==null)
	{
		alert ("您的浏览器不支持AJAX！")
		return false
	}
	xmlHttp.onreadystatechange=stateChanged3

	url=url+"&sj="+Math.random()
	xmlHttp.open("GET",url,true)
	xmlHttp.send(null)
}

function stateChanged3() 
{ 
	if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete")
	{
		document.getElementById('gongchang').innerHTML = xmlHttp.responseText;
	}
}