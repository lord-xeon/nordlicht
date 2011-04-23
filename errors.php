<?php
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