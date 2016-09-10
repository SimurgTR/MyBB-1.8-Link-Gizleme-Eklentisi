<?php
/*
Linkleri Gizleme Eklentisi v1.0
https://huseyinkorbalta.com
Copyright 2016  Huseyinkorbalta.Com
*/
if(!defined('IN_MYBB'))
	die('Bu dosyaya doğrudan erişemezsiniz!');
	
$plugins->add_hook("parse_message", "linklerigizle_parse");

function linklerigizle_info()
{

	return array(
		"name"		=> "İndirme Linklerini Gizle",
		"description"		=> "Konularınızda ki iç ve dış website bağlantılarını ziyaretçilerinize gizlemenizi sağlar ve gizlenen bu linkler yerine bir uyarı mesajı gösterir.",
		"website"		=> "https://huseyinkorbalta.com",
		"author"		=> "Hüseyin Körbalta",
		"authorsite"		=> "https://huseyinkorbalta.com",
		"version"		=> "1.0",
		"guid" 			=> "7725ba33bb01a4223b01fe0ee022d650",
		"compatibility"	=> "18"
		);
}


function linklerigizle_activate(){}
function linklerigizle_deactivate(){}

## Eklenti Parse Fonksiyonu
function linklerigizle_parse(&$message)
{
	global $lang, $mybb;
	

	if ($mybb->user['uid'] == 0)
	{
		$lang->load('linklerigizle');
		
		$lang->linklerigizle_mesaj = str_replace("{bburl}",$mybb->settings['bburl'],$lang->linklerigizle_mesaj);
		
		$message = preg_replace('#<a href="(.*?)</a>#i', $lang->linklerigizle_mesaj, $message);
		

	}
	
	
	return $message;

}


?>
