<?php
//require_once('config.php');
require_once('amo/nordlicht.php');
require_once('amo/Panzer.php');

$mv = array(
	'firefox',
	'safari',
	'chrome',
	'opera',
	'msie',
	'netscape',
	'mozilla'
);
$mmv = array(
	'firefox4.0',
	'firefox3.6',
	'firefox3.5',
	'firefox3.0',
	'firefox2.0',
	'firefox1.5',
	'firefox1',
	
	'chrome12',
	'chrome11',
	'chrome10',
	'chrome9',
	'chrome8',
	'chrome7',
	'chrome6',
	'chrome5',
	'chrome4',
	'chrome3',
	'chrome2',
	'chrome1.0',

	'opera11',
	'opera10',
	'opera9',
	'opera8',
	'opera7',
	'opera6',
	'opera5',	
	
	'safari6',
	'safari5',
	'safari4',
	'safari3',
	'safari2',
	'safari1.0',
	
	'msie11',
	'msie10',
	'msie9',
	'msie8',
	'msie7',
	'msie6',
	'msie5',
	'msie4',
	'msie3',
	'msie2',
	'msie1.0',
);

$browserOps = array(
	'firefox' => array(
		'color'=>'#d64203'
	),
	'safari' => array(
		'color'=>'#56009f'
	),
	'chrome' => array(
		'color'=>'#4db849'
	),
	'opera' => array(
		'color'=>'#be1e0a'
	),
	'msie' => array(
		'color'=>'#22b7ff'
	)	,
	'netscape'=> array(
		'color'=>'#274d50'
	),
	'mozilla'=> array(
		'color'=>'#ed1c24'
	),
	'Others'=> array(
		'color'=>'#5a1e3c'
	)
);

$sh = new Panzer();
$sh->fi='amo/awstats032011.blog.deadlycomputer.com.txt';
$sh->sec='BROWSER';
$sh->checked = $browserOps;
$sh->mv = $mv;
$sh->mmv = $mmv;
$sh->Browserbuilder();
?>
<section id="browser">
	<aside class="plotSide">
		<figure>
			<div id="browserPlot"></div>	
			<div class="minorPlot"></div>
			<figcaption></figcaption>
		</figure>
	</aside>
	<aside class="tableSide">
		<?php $sh->majorTable(); ?>
	</aside>
	<div class="minorHolder">
		<?php $sh->minorHold(); ?>
	</div>
	<br class="clear" />
	<?php $sh->destroy(); ?>
</section>