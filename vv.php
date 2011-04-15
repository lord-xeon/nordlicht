<?php 

echo '<p>initial memory used: ' .number_format(memory_get_usage()) ." bytes</p>";

require_once('../../funn/funnns.php');
require_once('nordlicht.php');
require_once('Sherman.php');
require_once('Panzer.php');

$code = strtoupper($_GET['sec']);
?>
<!DOCTYPE HTML>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>Untitled Document</title>
<link href="/nordlicht/funn/css/plugins/JSONtip-v2.css" type="text/css" rel="stylesheet" />
<link href="panzer.css" type="text/css" rel="stylesheet" />

</head>

<body>
<div id="flot"></div>
<div class="tableHold">
<?php
	echo "memory used: " .number_format(memory_get_usage())." bytes";

$checked = array(
	'Pages'=>array(
		'color'=>'#039',
		'on'=>false,
		'type'=>'lines'
	),
	'Hits'=>array(
		'color'=>'#090',
		'type'=>'lines',
		'on'=>true
	),
	'Bandwidth'=>array(
		'color'=>'#900',
		'type'=>'bars',
		'on'=>true
	)
);
$mv = array(
	'firefox',
	'safari',
	'chrome',
	'opera',
	'msie',
	'netscape',
	'mozilla'
	
);
$mmv = array(
	'firefox4.0',
	'firefox3.6',
	'firefox3.5',
	'firefox3.0',
	'firefox2.0',
	'firefox1.5',
	'firefox1',
	
	'chrome12',
	'chrome11',
	'chrome10',
	'chrome9',
	'chrome8',
	'chrome7',
	'chrome6',
	'chrome5',
	'chrome4',
	'chrome3',
	'chrome2',
	'chrome1.0',

	'opear11',
	'opear10',
	'opear9',
	'opear8',
	'opear7',
	'opear6',
	'opear5',	
	
	'safari6',
	'safari5',
	'safari4',
	'safari3',
	'safari2',
	'safari1.0',
	
	'msie11',
	'msie10',
	'msie9',
	'msie8',
	'msie7',
	'msie6',
	'msie5',
	'msie4',
	'msie3',
	'msie2',
	'msie1.0',
);

$h = 'safari';
$h1 = 'safari3.0';

//echo substr(

$sh = new Panzer();
$sh->fi='awstats032011.blog.deadlycomputer.com.txt';
$sh->sec=$code;
$sh->checked = $checked;
$sh->mv = $mv;
//$sh->mmv = $mmv;
$sh->builder();

$sh->majorTable();

$sh->debug();

?>
	<div class="meminfo">
		<?php	echo "memory used before destroy(): " .number_format(memory_get_usage())." bytes";
			$sh->destroy();
			echo "\nmemory used after destroy(): " .number_format(memory_get_usage())." bytes";
			echo "\npeak memory used: " .number_format(memory_get_peak_usage())." bytes"; ?>
	</div>
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.5/jquery.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.11/jquery-ui.min.js"></script>
<script src="/nordlicht/funn/js/plugins/jquery.JSONtip-v2.js"></script>
<script src="jquery.flot.js"></script>
<script>

var flotOps = {
		series: {
			points: {
				show: true,
				symbol: "circle"
			},
			bars: {
				points: {
					show: false
				}
			}
		},
		xaxis: {
			tickDecimals: 0
			
		},
		 yaxis: {
			 
        },
        grid: {
			hoverable: true,
			clickable:true
        }
	};
$(document).ready(function(){

	var oFlot = [];
	
	$(".nStats th").each(function(i,v){
		var $t = $(this),
			td = $t.data(),
			rd = [];
		oFlot[i] = new Array();
		if(td.charton == true) {
			$t.addClass('graphed');
			$('.nStats td:nth-child('+td.chartid+')').each(function(ind,val){
				var rowV = parseInt($(val).html());
				rd.push([ind,rowV]);
			});
			td.chartdata = rd;
			oFlot[i]['label'] = $t.html();
			oFlot[i]['data'] = rd;
			oFlot[i]['color'] = td.chartcolor;
			oFlot[i][td.charttype] = {show:true};
		}
	});
	
	if($("#flot").length >0 ) {
		$.plot($("#flot"), oFlot, flotOps);
	}
	$(".nStats th").click(function(e){
		e.preventDefault();
		var $t = $(this),
			td = $t.data(),
			flot = [];
		if(td.chartdata) {
			$t.toggleClass('graphed');
			if(td.charton == true) {
				td.charton = false;
			}
			else {
				td.charton = true;
			}
			$('.nStats th').each(function(i,v){
				var tdd = $(v).data();
				if(tdd.charton == true) {
					flot[i] = new Array();
					flot[i]['label'] = $(v).html();
					flot[i]['data'] = tdd.chartdata;
					flot[i]['color'] = tdd.chartcolor;
					flot[i][tdd.charttype] = {show:true};
				}
			});
			for(var j; j < flot.length; j++){
				if(!flot[j]){
					flot.unshift(j);
				}
			}
			$.plot($("#flot"), flot, flotOps);
		}
	});

	$("#flot").bind("plotclick",function (event, pos, item) {
		var tipData = {
			tipbody:'Hour: '+ item.datapoint[0] +' had ' +item.datapoint[1]+ " " + item.series.label
		};
		$(this).JSONtip({
			'tip-content':tipData.tipbody,
			'tip-x':item.pageX,
			'tip-y':item.pageY,
			'tip-width':175
		});
   });
   
   $(".wordCloud span").each(function(i){
		var $t = $(this),
	   		td = $t.data(),
			tc = '',
			y = Math.floor(Math.random()*90),
			x = Math.floor(Math.random()*90);
		if(!$t.hasClass('wordCloud-max')){
			$t.css({
				bottom:y+'%',
				left:x+'%'
			});
		}
		if(!td['tip-content']){
			var word = $t.html();
			tc = 'The word: <span class="searchTipWord">'+ word +'</span> has been searched for: <span class="searchTipVal">'+ td.searchvalue +'</span> times';
			tc += '<br>Representing <span class="searchTipVal">'+ td.searchpercent + '%</span> of the total search terms';
			td['tip-content'] = tc;
		}
		else {
			tc = td['tip-content'];
		}
		$t.JSONtip({
			'tip-class':'wordCloudTip',
			'tip-position':'bottomCenter',
			'tipbody':tc,
			'tip-show-event':'hover'
		});
	});
   
});
</script>
</body>
</html>