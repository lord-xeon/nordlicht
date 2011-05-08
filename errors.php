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
 #	Purpose: Error specific code for nordlicht v2 Omaha
/*=========================================*/

require_once('amo/nordlicht.php');
require_once('amo/Sherman.php');

$sh = new Sherman();
$sh->fi='amo/awstats032011.blog.deadlycomputer.com.txt';
$sh->sec='ERRORS';
$checked = array(
	'Hits'=>array(
		'color'=>'#090',
		'type'=>'lines',
		'yAxis'=>1,
		'on'=>true
	),
	'Bandwidth'=>array(
		'color'=>'#900',
		'type'=>'bars',
		'yAxis'=>2,
		'on'=>true
	));
$sh->checked = $checked;
$sh->typeMeta = $apacheStatusCode;
$sh->tableMeta = array('Errors','Hits','Bandwidth');
?>
<section id="errors">
	<aside class="tableSide">
<?php $sh->builder(); ?>
	</aside>
	<aside class="plotSide">
		<figure>
			<div id="errorsPlot"></div>
			<figcaption></figcaption>
		</figure>
	</aside>
</section>

<?php $sh->destroy(); ?>