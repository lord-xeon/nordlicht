<?php
require_once('amo/nordlicht.php');
require_once('amo/Sherman.php');

$ref = new Sherman();

$ref->fi='amo/awstats032011.blog.deadlycomputer.com.txt';
$ref->sec = 'ROBOT';

?>
<section id="robotsReffs">
	<section id="robots">
		<aside class="tableSide floatLeft">
			<?php 
				$ref->off = 2;
				$ref->limit = 10;
				$ref->tableMeta = array('Robot ID','Hits','Bandwidth', 'Hits on robots.txt'); ?>
			<h2>Top <?php echo $ref->limit; ?> Robots</h2>
			<?php $ref->builder(); ?>
		</aside>
		<aside class="tableSide floatRight">
			<?php
				$ref->sec = 'SEREFERRALS';
				$ref->tableMeta = array('Search engine referers ID','Pages','Hits');
				$ref->limit = 10;
				$ref->off = 1; ?>
			<h2>Top <?php echo $ref->limit; ?> Search Engine Refferals</h2>
			<?php $ref->builder(); ?>
			<figure>
				<div id="errorsPlot"></div>
				<figcaption></figcaption>
			</figure>
		</aside>
	</section>
	<?php 
		$ref->sec='PAGEREFS';
		$ref->off = 2;
		$ref->limit = 15;
		$ref->tableMeta = array('External page referers','Pages','Hits'); ?>
	<section>
		<h2>Top <?php echo $ref->limit; ?> Refferals</h2>
		<?php $ref->builder(); ?>
	</section>
</section>
<?php $ref->destroy(); ?>