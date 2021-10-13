// JavaScript Documentvar xmlhttp; 

var objdiv;
function get_emirate_location(para1,url,dis){  
	objdiv=dis;
	xmlhttp=GetXmlHttpObject();
	if (xmlhttp==null){
		alert ("Browser does not support HTTP Request");
		return;
	} 
	
	url=url+"/"+para1; 
	xmlhttp.onreadystatechange=stateChange;
	xmlhttp.open("POST",url,true);
	xmlhttp.send(null);
}  


function operate_mini_location_form_add(para1,url,dis){  
	objdiv=dis;
	xmlhttp=GetXmlHttpObject();
	if (xmlhttp==null){
		alert ("Browser does not support HTTP Request");
		return;
	} 
	 
	xmlhttp.onreadystatechange=stateChange;
	xmlhttp.open("POST",url,true);
	xmlhttp.send(null);
}
 
function stateChange(){
	if(xmlhttp.readyState==4 || xmlhttp.readyState=="complete"){ 
		document.getElementById(objdiv).innerHTML=xmlhttp.responseText;	
	}
}

function GetXmlHttpObject(){
	if(window.XMLHttpRequest){  // code for IE7+, Firefox, Chrome, Opera, Safari
 	   return new XMLHttpRequest();
    }
	if(window.ActiveXObject){ // code for IE6, IE5
		return new ActiveXObject("Microsoft.XMLHTTP");
  }
	return null;
}
