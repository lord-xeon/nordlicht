<?php require_once('config.php'); ?>
<!DOCTYPE HTML>
<head>
	<meta charset="utf-8">
	<title>Apache Statistics for: <?php echo $statsURL; ?> |Month: <?php echo substr($dayR,0,2).' |Year, '.substr($dayR,2,4);?></title>
	<meta name="description" content="statistics">
	<meta name="author" content="<?php echo $aweVerson; ?>">
	<link rel="shortcut icon" href="/favicon.ico">
	<link type="text/css" rel="stylesheet" href="funn/css/ruthless.css"/>
	<script src="funn/js/modernizr-1.6.min.js"></script>
</head>

<body>
  <div id="container">
    <header id="navHead">
		<p>Statists for <?php echo $statsURL;?>, for <?php echo $monthList[ltrim(substr($dayR,0,2),'0')].', '.substr($dayR,2,4); ?></p>
		<div id="controls">
			<?php fileDrop($stsList);?>
			<input type="text" value="<?php echo $dayR;?>" id="dayR" name="dayR" />
			<br class="clear" />
		</div> <!-- closes controls div -->
    </header>
	<nav>
    <ul id="nav">
        <li><a href="#today">Today</a>
			<span id="todayIcon" class="navIcon">
				<span><?php echo date('D');?></span>
				<?php echo date('d'); ?>
			</span> <!-- closes todayIcon span -->
		</li>
        <li><a href="#hours">Hourly</a>
			<span id="clock" class="navIcon">
				<span class="minHand"></span>
				<span class="hour<?php echo date('h');?> hourHand"></span>
				<span class="clockInner"></span>
			</span> <!-- closes clock span -->
		</li>
        <li><a href="#month">Monthly</a>
			<span id="monthIcon" class="navIcon">
				<span class="calRing"></span>
				<span class="calRing"></span>
				<span class="calPaper">
					<span class="calName"><?php echo date('M');?></span>
				</span>
			</span> <!-- closes monthIcon span -->
		</li>
        <li><a href="#browser">Browsers</a>
			<span id="browserIcon" class="navIcon">
			
			</span> <!-- closes browserIcon span -->
		</li>
        <li><a href="#os">Operating Systems</a>
			<span id="OSIcon" class="navIcon">
				<span class="OSscreen"></span>
				<span class="OSbase"></span>
			</span> <!-- closes OSIcon span -->
		</li>
        <li><a href="#domainIP">Countries</a>
			<span id="countryIcon" class="navIcon">
				<span class="ring ring1"></span>
				<span class="ring ring2"></span>
				<span class="ring ring3"></span>
				<span class="ring ring4"></span>
				<span class="ring ring5"></span>
			</span> <!-- closes countryIcon span -->
		</li>
        <li><a href="#domainIP">IP addresses</a>
			<span id="IPIcon" class="navIcon">
				<span class="IPcon"></span>
				<span class="IPcon"></span>
				<span class="IPright"></span>
				<span class="IPleft"></span>
			</span> <!-- closes IPIcon2 span -->
		</li>
        <li><a href="#content">File &amp; Pages</a>
			<span id="fileIcon" class="navIcon">
				<span></span>
			</span> <!-- closes fileIcon span -->
		</li>
        <li><a href="#reffs">Robots &amp; Refferals</a>
			<div id="robotIcon" class="navIcon">
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
        <li><a href="#searches">Searches</a>
			<span id="searchIcon" class="navIcon">
				<span></span>
			</span> <!-- closes searchIcon span -->
		</li>
		<li><a href="#errors">Errors</a>
			<span id="errorIcon" class="navIcon">
				X
			</span> <!-- closes errorIcon span -->
		</li>
    </ul>
	</nav>