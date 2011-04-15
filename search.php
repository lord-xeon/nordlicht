<?php
//require_once('config.php');
require_once('amo/nordlicht.php');
require_once('amo/Sherman.php');

	$keywords = new Sherman();
	$keywords->fi='amo/awstats032011.blog.deadlycomputer.com.txt';
	$keywords->sec='KEYWORDS';

	$keywords->off = 2;
	$keywords->meta = array('Search keywords','Number of search');

	$keywords->limit = 15;
	$keywords->destroy();

?>

<section id="search">
	<?php 
		$keywords->wordCloud();
		echo "<hr />\n";
		$keywords->sec='SEARCHWORDS';
		$keywords->limit = 10;
		$keywords->meta = array('Search keyphrases','Number of search');
		$keywords->wordCloud();
		$keywords->destroy();
	?>
</section>