<!DOCTYPE HTML>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>Untitled Document</title>
<link href="/nordlicht/testing/jquery-ui-1.8.11.custom.css" type="text/css" rel="stylesheet" />
<style>
	
</style>
</head>

<body>
<div id="mainContent">
	<nav id="tabNav">
		<ul>
			<li><a href="#tabs-1">Today</a></li>
			<li><a href="y2d.php">Year to Date</a></li>
			<li><a href="daily.php">Daily</a></li>
			<!--li><a href="#hourly">Hourly</a></li>
			<li><a href="#monthly">Monthly</a></li>
			<li><a href="#browserOS">Browser/OS</a></li>
			<li><a href="#geo">Geo</a></li>
			<li><a href="#content">Content</a></li>
			<li><a href="#robots">Robots</a></li>
			<li><a href="#searches">Searches</a></li-->
			<li><a href="amo/errors.php">Errors</a></li>
		</ul>
	</nav>
	<div id="tabs-1">
		<section id="today" class="statsSection"> 
			<h2>Month to Date</h2>
			<div id="todayStats">
				<p><span class="bold">Last Updated:</span> Friday, April 1, 2011 at: 9:17 p.m.</p> 
				<p> 10 new records since last update.</p> 
				<p>58 total visits this month</p> 
				<p>57 total uniques this month</p> 
			</div><!--closes todayStats div-->
		</section>
	</div>
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.5/jquery.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.11/jquery-ui.min.js"></script>
<script>
$(function(){
	$("#mainContent").tabs({
		ajaxOptions: {
			error: function( xhr, status, index, anchor ) {
					$( anchor.hash ).html(
						"Couldn't load this tab. We'll try to fix this as soon as possible. " +
						"If this wouldn't be a demo." );
				}
		}
	});
});
</script>
</body>
</html>