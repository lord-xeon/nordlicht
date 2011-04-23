<!DOCTYPE HTML>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>Layout setup</title>
<link href="css/jquery-ui-1.8.11.custom.css" type="text/css" rel="stylesheet" />
<link href="css/nav.css" type="text/css" rel="stylesheet" />
<style>
@import url(http://fonts.googleapis.com/css?family=Quattrocento);
@import url(http://fonts.googleapis.com/css?family=Expletus+Sans);

/*@1 Tabs*/
/*@1.1 Default Tab State*/
.ui-tabs {
	font-size:16px;
	font-family: 'Quattrocento', arial, serif;
	font-family: 'Expletus Sans', arial, serif;
}
.ui-widget-header {
	background:#053F60;
	border:none;
}

.ui-tabs .ui-tabs-nav li {
	border:3px solid #ccc;
	border-bottom:none;
	border-radius:8px 8px 0 0;
	margin:5px 5px 0;
	height:36px;
	width:36px;
	float:left;
	list-style:none;
	position:relative;
	-webkit-transition:0.1s ease-out;
	-moz-transition:0.3s ease-out;
}

/* We want to set the opacity instead of the display value because it works better with the transition
 */
.ui-tabs-nav li a {
	margin-left:32px;
	margin-top:5px;
	padding:5px 10px;
	float:left;
	color:#053F60;
	text-shadow:0 1px 1px #fff;
	opacity:0;
}

/*@1.2 Hovered State*/
.ui-tabs .ui-tabs-nav li:hover {
	width:130px;
	-webkit-transition:0.3s ease-in;
	-moz-transition:0.3s ease-in;
}
.ui-tabs .ui-tabs-nav li.year2DateTab:hover {
	width:160px;
	-webkit-transition:0.3s ease-in;
	-moz-transition:0.3s ease-in;
}
.ui-tabs .ui-tabs-nav li:hover a {
	-webkit-transition:0.25s ease-in;
	-moz-transition:0.25s ease-in;
	opacity:1;
}

/*@1.3 Selected State*/
.ui-tabs-nav li.ui-state-active {
	width:130px;
}
.ui-tabs .ui-tabs-nav li.ui-state-active.year2DateTab {
	width:160px;
}

.ui-tabs-nav li.ui-state-active a {
	color:#333;
	text-shadow:0 1px 1px #fff;
	opacity:1;
}

</style>
</head>

<body>
<div id="europe">
	<nav id="tabNav">
		<ul>
			<li><a href="#tabs-1">Today</a>
				<span class="navIcon todayIcon"> 
					<span><?php echo date('M');?></span>
					<?php echo date('j');?>
				</span> <!-- closes todayIcon span -->
			</li>
			<li class="year2DateTab"><a href="y2d.php">Year to Date</a></li>
			<li><a href="daily.php">Daily</a></li>
			<li><a href="hourly.php" data-flot="true">Hourly</a>
			</li>
			<li><a href="monthly.php">Monthly</a>
				<span class="navIcon monthIcon"> 
					<span class="calRing"></span> 
					<span class="calRing"></span> 
					<span class="calPaper"> 
						<span class="calName"><?php echo date("M");?></span> 
					</span> 
				</span> <!-- closes monthIcon span -->
			</li>
			<li><a href="browser.php">Browser</a></li>
			<li><a href="os.php">OS</a>
				<span class="navIcon OSIcon"> 
					<span class="OSscreen"></span> 
					<span class="OSbase"></span> 
				</span> <!-- closes OSIcon span --> 
			</li>
			<li><a href="#geo">Geo</a>
				<span class="navIcon countryIcon"> 
					<span class="ring ring1"></span> 
					<span class="ring ring2"></span> 
					<span class="ring ring3"></span> 
					<span class="ring ring4"></span> 
					<span class="ring ring5"></span> 
				</span> <!-- closes countryIcon span -->
			</li>
			<li><a href="#content">Content</a>
				<span class="navIcon fileIcon"> 
					<span></span> 
				</span> <!-- closes fileIcon span -->
			</li>
			<li><a href="robots.php">Robots</a>
				<div class="navIcon robotIcon"> 
					<span class="robotAntena"></span> 
					<span class="robotAntena"></span> 
					<div class="robotFace"> 
						<span class="robotEye"></span> 
						<span class="robotEye"></span> 
						<table class="robotMouth"> 
							<tr> 
								<td></td><td></td><td></td><td></td> 
							</tr> 
							<tr> 
								<td></td><td></td><td></td><td></td> 
							</tr> 
						</table> 
					</div> <!-- closes robotFace span--> 
				</div> <!-- closes robotIcon span--> 
			</li>
			<li><a href="search.php">Searches</a>
			</li>
			<li><a href="errors.php">Errors</a>
				<span class="navIcon errorIcon">X</span> <!-- closes errorIcon span -->
			</li>
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
	</div> <!-- closes europe div -->
</body>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.5/jquery.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.11/jquery-ui.min.js"></script>
<script src="js/flot.colorhelpers.js"></script>
<script src="js/color2.js"></script>
<script>
$(window).load(function(){
	$("#europe").tabs({
		load: function(e,uid){
			var sec = uid.tab.innerHTML.toLowerCase();
		},
		cache:true,
		fx: {
			opacity: 'toggle'
		},
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
</html>