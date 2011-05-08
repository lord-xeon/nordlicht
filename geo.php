<?php
/*===========================================
 #	browser.php is part of nordlicht v2 Omaha
 #	author: stephen giorgi
 #	author email: stephen.giorgi@alphavega.com
 #	
 #	last change: 05.07.2011
 #	licensed under GNU GPLv2
 #	see licenses/gnu.txt for full text
 #
 #	Purpose: GEO specific code for nordlicht v2 Omaha
/*=========================================*/

require_once('amo/nordlicht.php');
require_once('amo/Sherman.php');
require('amo/garand.php');

$geo = new Sherman();
$geo->fi='amo/awstats032011.blog.deadlycomputer.com.txt';
$geo->sec='DOMAIN';
$geo->off = 2;
$geo->limit = 20;
$geo->cccp($cc);

$geo->tableMeta = array('Domain','Hits','Pages','Bandwidth');
?>
<section id="geo">
	<figure>
		<div id="geoMap"></div>
	</figure>
	<aside class="tableSide">
		<?php $geo->builder(); ?>
	</aside>
	<aside class="ipSide">
		<?php
		$geo->sec="VISITOR";
		$geo->off = 3;
		$geo->tableMeta = array('Host','Pages','Hits','Bandwidth','Last visit date');
		$geo->builder();
		?>
	</aside>
</section>
<?php $geo->destroy(); ?>