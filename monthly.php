<?php
require_once('amo/nordlicht.php');
require_once('amo/Sherman.php');


$checked = array(
	'Pages'=>array(
		'color'=>'#039',
		'on'=>false,
		'yAxis'=>1,
		'type'=>'lines',
	),
	'Visits'=>array(
		'color'=>'#C0C',
		'on'=>false,
		'yAxis'=>2,
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
$monthly = new Sherman();
$monthly->fi='amo/awstats032011.blog.deadlycomputer.com.txt';
$monthly->sec='DAY';
$monthly->checked = $checked;
$monthly->tableMeta = array('Date','Pages','Hits','Visits','Bandwidth');
$monthly->limit = 15;

?>
<section id="monthly">
	<figure>
		<div id="monthlyFlot"></div>
		<figcaption></figcaption>
	</figure>
	<div id="monthlyTable">
		<?php $monthly->builder();
			$monthly->checked = array();
			$monthly->offSet = 15;
			$monthly->limit = null;
			$monthly->builder();
			$monthly->destroy();
		?>
	<br class="clear" />
	</div>
</section>

