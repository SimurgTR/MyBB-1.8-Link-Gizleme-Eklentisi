<?php
/*
Eklenti Adı: İndirme Linklerini Gizleme
Eklenti Yapımcısı: Hüseyin Körbalta
Eklenti Sürümü: v1.1
Eklenti Dili: Türkçe (Turkish)
Eklenti MyBB Sürüm Uyumluluğu: MyBB 1.8.X
Test Sürümü: MyBB 1.8.7
Yapım Tarihi: 10.09.2016
Yapımcı Website: https://huseyinkorbalta.com
*/
// Eklenti Dosyalarına Dışarıdan Erişim Engellendi!
	if(!defined("IN_MYBB"))
	{
		die("Bu dosyaya doğrudan erişim sağlayamazsınız.");
	}

	//Eklenti için Plugin Library Gerekli!
	//https://github.com/SimurgTR/MyBB-1.8-Plugin-Library
	if(!defined("PLUGINLIBRARY"))
	{
		define("PLUGINLIBRARY", MYBB_ROOT."inc/plugins/pluginlibrary.php");
	}
	
$plugins->add_hook("parse_message", "linklerigizle_parse");
	
function linklerigizle_info ()
{
	global $lang;
	$lang->load('linklerigizle');
	return array(
		"name"			=> $lang->linklerigizle_isim,
		"description"	=> $lang->linklerigizle_aciklama,
		"website"		=> 'https://github.com/SimurgTR/MyBB-1.8-Link-Gizleme-Eklentisi/',
		"author"		=> 'Hüseyin Körbalta',
		"authorsite"	=> 'https://huseyinkorbalta.com',
		"version"		=> "1.1",
		"compatibility" => "18*"
		);
}

function linklerigizle_is_installed()
{
    global $settings;

    if(isset($settings['linklerigizle_ayarlar_acik']))
    {
        return true;
    }
}

function linklerigizle_install()
{
    if(!file_exists(PLUGINLIBRARY))
    {
        flash_message("Aktif etmeye çalıştığınız eklenti aktif edilemiyor.Eklenti için PluginLibray eklentisi gerekmektedir.Bu uyarıyı alıyorsanız bu eklenti sizde yoktur demektedir. Lütfen, <a href=\"https://github.com/SimurgTR/MyBB-1.8-Plugin-Library\">buradan</a> PluginLibrary eklentisini indiriniz.", "error");
        admin_redirect("index.php?module=config-plugins");
    }
    global $PL;
    $PL or require_once PLUGINLIBRARY;
	
	//Versiyon Kontrol
    if($PL->version < 12)
    {
        flash_message("Sitenizde PluginLibrary'nin eski bir sürümü mevcut. Lütfen eklentiyi son sürüme güncelleyiniz. Son sürümü <a href=\"https://github.com/SimurgTR/MyBB-1.8-Plugin-Library\">buradan</a> indiriniz.", "error");
        admin_redirect("index.php?module=config-plugins");
    }
}

function linklerigizle_uninstall()
{
    global $PL;
    $PL or require_once PLUGINLIBRARY;

    //Ayarları Sil
    $PL->settings_delete("linklerigizle_ayarlar"
        );
}

function linklerigizle_activate()
{
    global $PL,$lang, $mybb;
    $PL or require_once PLUGINLIBRARY;
	$lang->load('linklerigizle');
    $PL->settings("linklerigizle_ayarlar", 
                  $lang->linklerigizle_ayarlar_isim,
                  $lang->linklerigizle_ayarlar_aciklama,
                  array(
                      "acik" => array(
                          "title" => $lang->linklerigizle_eklenti_acik,
                          "description" => $lang->linklerigizle_eklenti_acik_aciklama,
						  'value' => 1,
						  'disporder' => 1
                          ),
                      )
        );	
}

function linklerigizle_deactivate()
{
    global $PL;
    $PL or require_once PLUGINLIBRARY;
    $PL->cache_delete("linklerigizle_ayarlar"
        );
}

function linklerigizle_parse(&$message)
{
	global $lang, $mybb;
	if($mybb->settings['linklerigizle_ayarlar_acik'] == 1)
{
	if ($mybb->user['uid'] == 0)
	{
		$lang->load('linklerigizle');
		
		$lang->linklerigizle_mesaj = str_replace("{bburl}",$mybb->settings['bburl'],$lang->linklerigizle_mesaj);
		
		$message = preg_replace('#<a href="(.*?)</a>#i', $lang->linklerigizle_mesaj, $message);
		
	}
	
	
	return $message;
}
}		
?>
