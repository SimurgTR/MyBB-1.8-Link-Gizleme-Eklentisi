<?php
/*
Linkleri Gizleme Eklentisi v1.0
https://huseyinkorbalta.com
Copyright 2016  Huseyinkorbalta.Com
*/
if(!defined('IN_MYBB'))
	die('Bu dosyaya doğrudan erişemezsiniz!');
	
$plugins->add_hook("parse_message", "registeredlinks_process");

function registeredlinks_info()
{

	return array(
		"name"		=> "Ziyaretçilere Link Gizleme",
		"description"		=> "Konudaki linklerin ziyaretçilere gizlemesini sağlar.",
		"website"		=> "https://huseyinkorbalta.com",
		"author"		=> "Machine",
		"authorsite"		=> "https://huseyinkorbalta.com",
		"version"		=> "1.0",
		"guid" 			=> "7725ba33bb01a4223b01fe0ee022d650",
		"compatibility"	=> "18"
		);
}


function registeredlinks_install()
{

	

}



function registeredlinks_uninstall()
{

}




function registeredlinks_process(&$message)
{
	global $lang, $mybb;
	

	if ($mybb->user['uid'] == 0)
	{
		$lang->load('registeredlinks');
		
		$lang->reglinks_text = str_replace("{bburl}",$mybb->settings['bburl'],$lang->reglinks_text);
		
		$message = preg_replace('#<a href="(.*?)</a>#i', $lang->reglinks_text, $message);
		

	}
	
	
	return $message;

}


?>
