<?php
require_once('amo/nordlicht.php');
require_once('amo/Panzer.php');
require_once('amo/Panther.php');

$mmv = array(
	'winlong',
	'win2008',
	'win2003',
	'winxp',
	'win2000',
	'winnt',
	'winme',
	'wince',
	'win98',
	'win95',
	'win16',
	'winunknown',

	'macosx',
	
	'linux',
	'linuxdebian',
	'linuxubuntu',
	'linuxgentoo',
	'linuxsuse',
	'linuxfedora',
	'linuxredhat',
	'linuxmandr',
	'linuxcentos',
	'linuxpclinuxos'
);

$mv = array(
	'win',
	'mac',
	'linux',
	'mobile'
);

$OSops = array(
	'win' => array(
		'color'=>'#275598'
	),
	'mac' => array(
		'color'=>'#56009f'
	),
	'linux' => array(
		'color'=>'#752900'
	),
	'Unknown' => array(
		'color'=>'#8bb82d'
	)
);


$sh = new Panther();

$sh->fi='amo/awstats032011.blog.deadlycomputer.com.txt';
$sh->sec='OS';
$sh->builder();

$sh->checked = $OSops;
$sh->mv = $mv;
$sh->mmv = $mmv;
$sh->limit = 10;
$sh->OSbuilder();
?>
<section id="os">
	<aside class="tableSide">
		<h3>Top <?php echo $sh->limit; ?> Operating Systems</h3>
		<?php $sh->majorTable(); ?>
	</aside><!--closes tableSide-->
	<aside class="plotSide">
		<figure>
			<div id="osPlot"></div>
			<div class="minorPlot"></div>
			<figcaption></figcaption>
		</figure>
	</aside> <!--closes plotSide-->
	<div class="minorHolder">
		<?php $sh->OSminor();
			$sh->destroy(); ?>
	</div> <!-- closes minotHolder div -->
	<br class="clear" />
</section> <!--closes OS section-->