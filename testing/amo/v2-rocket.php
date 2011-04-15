<!DOCTYPE HTML>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>Nordlicht V-2 []</title>
<link href="/nordlicht/testing/jquery-ui-1.8.11.custom.css" type="text/css" rel="stylesheet" />
<!--link href="/nordlicht/funn/css/alsos.css" type="text/css" rel="stylesheet" /-->
<link href="/nordlicht/funn/css/plugins/JSONtip-v2.css" type="text/css" rel="stylesheet" />
<link href="panzer.css" type="text/css" rel="stylesheet" />

</head>

<body>
<p>
<?php
	echo "memory used before destroy(): " .number_format(memory_get_usage())." bytes";
	echo "\nmemory used after destroy(): " .number_format(memory_get_usage())." bytes";
	echo "\npeak memory used: " .number_format(memory_get_peak_usage())." bytes";
?>
</p>
<div id="mainContent">
	<nav id="tabNav">
		<ul>
			<li><a href="#tabs-1">Today</a>
				<span id="todayIcon" class="navIcon">
					<span><?php echo date('D');?></span>
					<?php echo date('d'); ?>
				</span> <!-- closes todayIcon span -->
			</li>
			<li><a href="y2d.php">Year to Date</a></li>
			<li><a href="daily.php">Daily</a></li>
			<li><a href="hourly.php" data-flot="true">Hourly</a>
				<span id="clock" class="navIcon">
					<span class="minHand"></span>
					<span class="hour<?php echo date('h');?> hourHand"></span>
					<span class="clockInner"></span>
				</span> <!-- closes clock span -->
			</li>
			<li><a href="monthly.php">Monthly</a>
				<span id="monthIcon" class="navIcon">
					<span class="calRing"></span>
					<span class="calRing"></span>
					<span class="calPaper">
						<span class="calName"><?php echo date('M');?></span>
					</span>
				</span> <!-- closes monthIcon span -->
			</li>
			<li><a href="#browserOS">Browser/OS</a></li>
			<li><a href="#geo">Geo</a></li>
			<li><a href="#content">Content</a></li>
			<li><a href="#robots">Robots</a></li>
			<li><a href="search.php">Searches</a>
				<span id="searchIcon" class="navIcon">
					<span></span>
				</span> <!-- closes searchIcon span -->
			</li>
			<li><a href="errors.php">Errors</a></li>
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
</div> <!-- closes mainContent div -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.5/jquery.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.11/jquery-ui.min.js"></script>
<script src="amo.js"></script>
<script src="/nordlicht/funn/js/plugins/jquery.JSONtip-v2.js"></script>
<script src="jquery.flot.js"></script>
<script>
$(document).ready(function(){
	
	$("#mainContent").tabs({
		load: function(e,uid){
			var sec = uid.tab.innerHTML.toLowerCase(),
				flotID = "#"+sec+'Flot',
				$flotID = $(flotID),
				oFlot = [];
			if(sec == 'searches'){
				$(".wordCloud span").each(function(i){
					var $t = $(this),
						td = $t.data(),
						tc = '',
						y = Math.floor(Math.random()*90),	//random number between 0 and 90 [90 choosen so that the max the word will be is 90%, otherwise it shows up outside the box]
						x = Math.floor(Math.random()*90);
					if(!$t.hasClass('wordCloud-max')){
						$t.css({
							bottom:y+'%',	//these are set as percentages so that you can resize the box as you see fit
							left:x+'%'
						});
					}
					//builds the tip content and puts it into the span's .data() attribute
					if(!td['tip-content']){
						var word = $t.html();
						tc = 'The word: <span class="searchTipWord">'+ word +'</span> has been searched for: <span class="searchTipVal">'+ td.searchvalue.toString().addCommas() +'</span> times';
						tc += '<br>Representing <span class="searchTipVal">'+ td.searchpercent + '%</span> of the total search terms';
						td['tip-content'] = tc;
					}
					else {
						tc = td['tip-content'];
					}
					$t.JSONtip({
						'tip-class':'wordCloudTip',		//the wordCloud tip uses a smaller font, and wider tip
						'tip-position':'bottomCenter',	//always want the tip to show up on the bottom center
						'no-close':true,				//we don't want to see the close icon since we're doing a mouse enter event
						'tipbody':tc,					//set the tip body to be the text we built above
						'tip-show-event':'hover'		//we want a hover event for the word cloud
					});
				});
				return;
			}
			
			$("#"+sec+" .nStats th").each(function(i,v){
				var $t = $(this),
					td = $t.data(),
					rd = [];
				oFlot[i] = new Array();
				if(td.chartid){
					$("#"+sec+' .nStats td:nth-child('+td.chartid+')').each(function(ind,val){
						var rowV = parseInt($(val).html().replace(',',''));
						rd.push([ind,rowV]);
					});
				}
				td.chartdata = rd;
				if(td.charton == true) {
					$t.toggleClass('graphed');
					oFlot[i] = new Array();
					oFlot[i]['label'] = $t.html();
					oFlot[i]['data'] = td.chartdata;
					oFlot[i]['color'] = td.chartcolor;
					oFlot[i][td.charttype] = {show:true};
				}
			});
			flotOps.legend.container = $("#"+sec+" figcaption");
			if($flotID.length > 0){
				$.plot($flotID, oFlot, flotOps);
			}
			
			$("#"+sec+" .nStats th").click(function(e){
				e.preventDefault();
				var $t = $(this),
					td = $t.data(),
					flot = [],
					flot2 = [];
				if(td.chartdata) {
					$t.toggleClass('graphed');
					if(td.charton == true) {
						td.charton = false;
					}
					else {
						td.charton = true;
					}
					$("#"+sec+' .nStats th').each(function(i,v){
						var tdd = $(v).data();
						if(tdd.charton == true) {
							flot[i] = new Array();
							flot[i]['label'] = $(v).html();
							flot[i]['data'] = tdd.chartdata;
							flot[i]['color'] = tdd.chartcolor;
							flot[i][tdd.charttype] = {show:true};
						}
					});
					for(var j = 0; j < flot.length; j++){
						if(flot[j] != undefined){
							flot2.push(flot[j]);
						}
					}
					delete flot;
					$.plot($flotID, flot2, flotOps);
				}
			});
			
			$($flotID).bind("plothover",function(event, pos, item) {
				var tipData = {
					tipbody:'Hour: '+ item.datapoint[0] +' had ' +item.datapoint[1]+ " " + item.series.label
				};
				$(this).JSONtip({
					'tipbody':tipData.tipbody,
					'tip-x':item.pageX,
					'tip-y':item.pageY,
					'tip-width':175
				});
		   });
			
			
		},
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
</body>
</html>