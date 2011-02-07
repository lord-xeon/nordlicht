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
		body { width:80%; margin:0 auto; font-size:24px; font-family:"PT Sans", Verdana, Geneva, sans-serif; color:#fff; }
		h1 {
			text-align:center;
			text-shadow:2px 2px 4px rgba(167,231,215,0.9),
						4px 4px 8px rgba(167,231,215,0.5),
						8px 8px 12px rgba(167,231,215,0.1);
			color:rgba(167,213,215,0.8);
		}		
		section { 
			margin:0 auto;
			width:600px;
		}
		img { margin:0 auto; text-align:center; display:block; }
		#controls {
			position:relative;
			margin:0 auto;
		}
		#dayR {
		    position:absolute;
			left:318px;
		    top:10px;
		}
		.goButton {
			position:absolute;
			top:-16px;
			right:0;
		}
	</style>
</head>
<body>
	<header>
		<h1>AWStats using nordlicht for: <?php echo $domain;?></h1>
	</header>
	<section id="splashPage">
		<img src="funn/img/others/aurora.jpg" alt="northern lights" />
		<p>Welcome to the stats section of <?php echo $domain; ?>.  Please choose a subdomain, and date below.</p>
		<div id="controls">
			<input type="text" id="dayR" name="dayR" />
			<a href="juno.php" title="Go to Stats" id="goToStats" class="goButton">Go!</a>
			<?php fileDrop($stsList);?>
		</div>
	</section>
	<footer>
		Made with <a href="http://awstats.org/" title="AWStats"><?php echo $sts[0];?></a> using <a href="http://www.alphavega.com/nordlicht/" title="nordlicht">nordlich version <?php echo $nordlich; ?></a>.
    </footer>
</div> <!--! end of #container -->
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.4.4/jquery.min.js"></script>
<script type="text/javascript" src="funn/js/ultra.js"></script>
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