<pre>
<?php
$statsURL = $_GET['stats'];
$dayR = date('mY');
//require('../funn/config.php');
?>
</pre>
<!DOCTYPE HTML>
<head>
	<meta charset="utf-8">
	<title>Apache Statistics for: steve.deadlycomputer.com |Month: 12 |Year, 2010</title>
	<meta name="description" content="statistics">
	<meta name="author" content="">
	<link rel="shortcut icon" href="../favicon.ico">
	<link type="text/css" rel="stylesheet" href="../funn/css/alsos.css"/>
	<link type="text/css" rel="stylesheet" href="../funn/css/JSONtip.css"/>

	<script src="../funn/js/modernizr-1.7.cust.js"></script>
	<script>var dayR = '<?php echo $dayR;?>', statsURL = '<?php echo $statsURL;?>';</script>
	<style>		
		#echold {
			position:relative;
			width:95%;
			height:400px;
			border:2px solid #069;
			background:#06C;
			margin:40px auto;
		}
		.errorCode {
			position:absolute;
		}
		#four04 {
			top:10px;
			left:30px;
		}
		#five00 {
			top:100px;
			right:50px;
		}
		#three01 {
			bottom:200px;
			right:50px;
		}
		.JSONtipContainer {
			position:relative;
			z-index:100;
		}
		#tip {
			width:300px;
			height:200px;
			position:relative;
			margin:0 auto;
			z-index:100;
		}
		
		.cloud1, .cloud2, .cloud3, .cloud4, .cloud5, .cloud6, .cloud7 {
			position:absolute;
			border:3px solid #06C;
			background:#fff;
		}
		.cloud1 {
			width:100px;
			height:200px;
			top:-40px;
			left:-30px;
			border-radius:70%;
			z-index:110;
		}
		.cloud2 {
			width:150px;
			height:200px;
			left:25px;
			top:-25px;
			border-radius:70%;
			z-index:120;
		}
		.cloud3 {
			width:200px;
			height:150px;
			right:-20px;
			top:-40px;
			border-radius:85%;
			z-index:130;
		}
		.cloud4 {
			width:100px;
			height:50px;
			right:70px;
			bottom:-20px;
			border-radius:50%;
			z-index:120;
		}
		.cloud5 {
			width:150px;
			height:200px;
			bottom:-15px;
			right:-30px;
			border-radius:65%;
			z-index:120;
		}
		.cloud6 {
			width:50px;
			height:50px;
			right:-20px;
			top:50px;
			border:none;
			border-radius:50%;
			z-index:150;
		}
		.cloud7 {
			width:200px;
			height:100px;
			bottom:-20px;
			left:-30px;
			border-radius:55%;
		}
		#tipContent {
			position:absolute;
			top:-2px;
			left:-2px;
			background:white;
			color:black;
			z-index:500;
			width:290px;
			height:200px;
			border-radius:10px;
			overflow:scroll;
			overflow-x:hidden;
		}
		#tipContent h4 {
			text-align:center;
			font-family:Verdana, Geneva, sans-serif;
			font-size:18px;
			color:#fff;
			text-shadow:0 0 4px #06C;
		}
		#tipContent p {
			font-family: Georgia, "Times New Roman", Times, serif;
			font-size: 12px;
			margin: 5px auto;
			width: 80%;
		}
		#tip .JSONtipArrow {
		}
		#tip inArrow {
			
		}
	</style>


</head>

<body>
<div id="echold">
	<a href="#" class="errorCode fullList" data-jsondata='404' title="404 error" id="four04" data-tiphead="404 error" data-tipbody="this is a 404 error!" data-fadeoutspeed="2000">404 error?</a>
	<a href="#" class="errorCode fullList" data-jsondata='500' title="500 error bitch" id="five00" data-tipPosition="topCenter" data-autoPosition="false">500 error?</a>
	<a href="#" class="errorCode fullList" data-jsondata='301' title="301 error!" id="three01">301 error?</a>
	<div id="tip">
		<div class="cloud1"></div>
		<div class="cloud2"></div>
		<div class="cloud3"></div>
		<div class="cloud4"></div>
		<div class="cloud5"></div>
		<div class="cloud6"></div>
		<div class="cloud7"></div>
		<div class="JSONtipArrow">
			<div class="inArrow"></div>
		</div>
		<div id="tipContent">
			<h4>Not Found</h4>
			<p class="JSONtipBody">The server has not found anything matching the Request-URI. No indication is given of whether the condition is temporary or permanent. The 410 (Gone) status code SHOULD be used if the server knows, through some internally configurable mechanism, that an old resource is permanently unavailable and has no forwarding address. This status code is commonly used when the server does not wish to reveal exactly why the request has been refused, or when no other response is applicable.</p>
		</div>
	</div>
</div>

<div id="cloudTip" class="JSONtip tipRight " style="display:none;" >
	<div class="cloud1"></div>
	<div class="JSONtipContainer">
		<span class="JSONtipClose">x</span>
		<div class="JSONtipArrow">
			<div class="inArrow"></div>
		</div>
		<h4>Not Found</h4>
			<p class="JSONtipBody">The server has not found anything matching the Request-URI. No indication is given of whether the condition is temporary or permanent. The 410 (Gone) status code SHOULD be used if the server knows, through some internally configurable mechanism, that an old resource is permanently unavailable and has no forwarding address. This status code is commonly used when the server does not wish to reveal exactly why the request has been refused, or when no other response is applicable.</p>
		</div>
	</div> <!-- closes JSONtipContainer -->
	<div id="ec"></div>
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.5/jquery.min.js"></script>
<!--script type="text/javascript" src="funn/js/ultra.js"></script-->
<script type="text/javascript" src="../funn/js/plugins/jquery.JSONtip.js"></script>
<script type="text/javascript">
$(document).ready(function(){
	$("a.errorCode").JSONtip({
		json: 'funn/js/json/errorCodes2.php',
		inlineParse:true
	}).attr('title','superAWESOME');
});
</script>
</body>
</html>