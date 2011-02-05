<?php require_once('funn/config.php');?>
<!DOCTYPE HTML>
<head>
	<meta charset="utf-8">
	<title>AWStats using nordlicht for: <?php echo $domain;?></title>
	<meta name="description" content="statistics">
	<meta name="author" content="<?php echo $aweVerson; ?>">
	<link rel="shortcut icon" href="/favicon.ico">
	<link type="text/css" rel="stylesheet" href="funn/css/ruthless.css"/>
	<script src="funn/js/modernizr-1.6.min.js"></script>
	<style>
		body { background:#fff; }
		header { }
	</style>
</head>
<body>
	<header>
		<h1>AWStats using nordlicht for: <?php echo $domain;?></h1>
	</header>
	<section>
		<p>Welcome to the stats section of <?php echo $domain; ?>.  Please choose a subdomain, and date below.</p>
		<div>
			<?php fileDrop($stsList);?>
			<input type="text" id="dayR" name="dayR" />
			<a href="juno.php" title="Go to Stats" id="goToStats">Go!</a>
		</div>
	</section>
	<footer>
		Made with <a href="http://awstats.org/" title="AWStats"><?php echo $sts[0];?></a> using <a href="http://www.alphavega.com/nordlicht/" title="nordlicht">nordlich version <?php echo $nordlich; ?></a>.
    </footer>
</div> <!--! end of #container -->
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.4.4/jquery.min.js"></script>
<script type="text/javascript" src="funn/js/ultra.min.js"></script>
<script type="text/javascript">
	$("#goToStats").click(function(e){
		e.preventDefault();
		var href, dayR = $('#dayR').val(), dayR2;

		href = 'stats-'+$('#siteSelect').val();
		if(dayR) {
			dayR2 = dayR.split("/");
			href += '-'+dayR2[0]+dayR2[2];
		}
		$(this).attr('href', href)
		console.log($(this).attr('href'));
		window.location.href=$(this).attr('href');
	});
</script>
</body>
</html>