<?php
require_once('nordlicht.php');
include_once('garand.php');

$sec = strtoupper($_GET["section"]);
$offset = $_GET["offset"] ? $_GET["offset"] : 1;
$view = $_GET["view"];
$perPage = $_GET["perPage"] ? $_GET["perPage"] : 10;

$data = array();
if($sec == null):
	$data["error"] = "error, no section given...";
	echo json_encode($data);
	return;
endif;
$battle = new nordlicht();

$battle->fi = "awstats122011.blog.deadlycomputer.com.txt";
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
?>