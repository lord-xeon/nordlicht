<?php
require_once('amo/nordlicht.php');
require_once('amo/Sherman.php');


$checked = array(
	'Pages'=>array(
		'color'=>'#039',
		'on'=>false,
		'yAxis'=>1,
		'type'=>'lines'
	),
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
	)
);
$time = new Sherman();
$time->fi='amo/awstats032011.blog.deadlycomputer.com.txt';
$time->sec='TIME';
$time->checked = $checked;
$time->tableMeta = array('Hour','Pages','Hits','Bandwidth');
$time->limit = 12;

?>
<section id="hourly">
	<figure>
		<div id="hourlyPlot"></div>
		<figcaption></figcaption>
	</figure>
	
	<div id="hourlyTable">
		<?php $time->builder();
			$time->checked = array();
			$time->offSet = 12;
			$time->builder();
			$time->destroy();
		?>
	</div>
	<br class="clear" />
</section>

