<?php
require_once("connect.php");
require_once('nordlicht.php');
include_once('garand.php');

$sec = strtoupper($_GET["section"]);
$offset = $_GET["offset"] ? $_GET["offset"] : 1;
$view = $_GET["view"];
$perPage = $_GET["perPage"] ? $_GET["perPage"] : 10;
$siteid = $_GET["siteid"];
$sitename = $_GET['sitename'];
$date = $_GET["date"];
$req = $_GET["req"];
$sendData = array();


if($req == "siteList"):
	$lstSql = 'SELECT *
				FROM `sites`';
	$res = mysql_query($lstSql);
	$siteList = array();
	$i = 0;
	while($row2 = mysql_fetch_array($res)):
		$site = array();
		$site['nicesitename'] = $row2['nice-site-name'];
		$site['site'] = $row2['site'];
		$site['siteid'] = $row2['id'];
		$site['lastupdate'] = $row2['last-update'];
		$site['firstupdate'] = $row2['first-date'];
		$siteList[$i] = $site;
		$i++;
	endwhile;
	
	$sites["sitelist"] = $siteList;
	
	echo json_encode($sites);
	mysql_close();
	return;
	
elseif($req == "stats"):
	$dirSQL = 'SELECT `value`
				FROM `admin`
				WHERE `field-name`
				LIKE "stats-dir"';
	$res2 = mysql_query($dirSQL);
	$dirAr = mysql_fetch_array($res2);
	
	if($sitename == null):
		$siteSQL = 'SELECT * 
					FROM `sites`
					WHERE `id`
					= '.$siteid.'';
		$siteMy = mysql_query($siteSQL);
		$siteAr = mysql_fetch_array($siteMy);
		$siteNm = $siteAr['site'];
	else:
		$siteNm = $sitename;
	endif;
	
	$fi = $dirAr['value'] . "awstats". $date .".". $siteNm .".txt";
	
	$data = array();
	if($sec == null):
		$data["error"] = "error, no section given...";
		echo json_encode($data);
		return;
	endif;
	$battle = new nordlicht();
	
	$battle->fi = $fi;
	$battle->sec = $sec;
	$battle->off = $offset;
	$battle->perPage = $perPage;
	if($sec == "DOMAIN"):
		$battle->cc = $cc;
		$battle->ccc = $ccc;
	elseif($sec == "BROWSER"):
		$battle->browsers = $browsers;
	endif;
	$battle->builder();
	
	
	if($view === true):
		$battle->sendPrettyArray();
	else:
		$battle->sendJSON();
	endif;
	
	$battle->destroy();
	mysql_close();
	return;
elseif($req == "siteinfo"):
	$siteSQL = 'SELECT * 
				FROM `sites`
				WHERE `id`
				= '.$siteid.'';
	$siteMy = mysql_query($siteSQL);
	
	while($siteAr = mysql_fetch_array($siteMy)):
		$data['siteid'] = $siteAr['id'];
		$data['nicename'] = $siteAr['nice-site-name'];
		$data['firstdate'] = $siteAr['first-date'];
		$data['lastupdate'] = $siteAr['last-update'];
		$data['site'] = $siteAr['site'];
	endwhile;
	mysql_close();
endif;

if($view === true):
	echo "<pre>";
	print_r($data);
	echo "</pre>";
else:
	echo json_encode($data);
endif;

?>