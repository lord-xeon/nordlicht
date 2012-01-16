<!DOCTYPE HTML>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>nordlicht v3</title>
<link type="text/css" rel="stylesheet" href="amo/css/sunny/jquery-ui-1.8.16.custom.css" />
<link type="text/css" rel="stylesheet" href="amo/css/ui.jqgrid.css" />
<link type="text/css" rel="stylesheet" href="amo/css/jquery.ui.selectmenu.css" />
<link type="text/css" rel="stylesheet" href="amo/css/omaha/omaha.css" />
<script src="amo/js/modernizr.js"></script>
</head>

<body>
<header id="top-head">
	<h2 id="site-name"></h2>
    <h3 id="site-month"></h3>
	<div id="show-settings">Show Settings</div>
</header>
<section id="nordlicht">
    <ul id="nav">
        <li><a href="#global" title="Global Data">Global Data</a></li>
        <li><a href="time.php" title="Time of Day" data-section="time" data-offset="1">Time of Day</a></li>
        <li><a href="day.php" title="Day of Month" data-section="day" data-offset="1">Day of Month</a></li>
        <li><a href="domain.php" title="Countries" data-section="domain" data-offset="2">Countries</a></li>
        <li><a href="visitor.php" title="IPs" data-section="visitor" data-offset="3">IPs</a></li>
        <li><a href="browser.php" title="Browser" data-section="browser" data-offset="2">Browser</a></li>
    </ul>
   	<section id="global">
    	<h2>This is the global data section</h2>
    </section>	<!-- closes global section -->
</section> <!-- closes nordlicht section -->
<div id="settings-dialog">
	<select id="site-list"></select>
    <input type="date" id="month-date" placeholder="Starting Month" />
</div> <!-- closes settings-dialog div -->
<div id="global-load" class="ui-widget-loading-large hidden"></div>
</body>
<script src="amo/js/jquery/jquery.1.7.1.source.js"></script>
<script src="amo/js/jquery/jquery-ui-1.8.16.custom.min.js"></script>
<script src="amo/js/require.js" data-main="amo/js/eisenhower" defer></script>
</html>