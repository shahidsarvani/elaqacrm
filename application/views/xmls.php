<?php 
	if(isset($xml) && $xml!=''){
		header('Content-type: text/xml; charset=utf-8');
		echo $xml;
	}