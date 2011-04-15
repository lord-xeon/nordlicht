<!DOCTYPE HTML>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>nordlicht v2.0 test</title>
<style>
#y2d, #errors {
	display:none;
}
</style>
</head>

<body>
<nav id="tabNav">
<ul>
	<li><a href="#today">Today</a></li>
	<li><a href="#y2d">Year to Date</a></li>
	<li><a href="#daily">Daily</a></li>
	<!--li><a href="#hourly">Hourly</a></li>
	<li><a href="#monthly">Monthly</a></li>
	<li><a href="#browserOS">Browser/OS</a></li>
	<li><a href="#geo">Geo</a></li>
	<li><a href="#content">Content</a></li>
	<li><a href="#robots">Robots</a></li>
	<li><a href="#searches">Searches</a></li-->
	<li><a href="#errors">Errors</a></li>
</ul>

</nav>
<div id="innerContent">

<section id="today" class="statsSection"> 
	<h2>Month to Date</h2>
	<div id="todayStats">
		<p><span class="bold">Last Updated:</span> Friday, April 1, 2011 at: 9:17 p.m.</p> 
		<p> 10 new records since last update.</p> 
		<p>58 total visits this month</p> 
		<p>57 total uniques this month</p> 
	</div><!--closes todayStats div-->
</section> <!-- closes today section -->

<section id="y2d" class="statsSection">
	<h2>Year to Date</h2>
	<img src="http://chart.apis.google.com/chart?&amp;chs=600x300&amp;cht=ls&amp;chtt=Year+to+Date&amp;chf=bg,lg,30,EFEFEF,0,616161,3|c,s,F8F5F5&amp;chxl=0:|Jan.|Feb.|Mar.|April|May|June|July|Aug.|Sept.|Oct.|Nov.|Dec.&amp;chxr=0,0,12|1,0,6000|2,0,300&amp;chxs=2,EFEFEF,11.5,0,l,676767&amp;chxt=x,y,r&amp;chdl=Pages|Visits&amp;chdlp=b&amp;chma=10,10,10,10|0,25&amp;chg=9,10&amp;chls=2|2&amp;chm=b,FFFF88,0,1,0,1&amp;chts=C3D9FF,13.5&amp;chco=008000,AA0033&amp;chds=0,7993,0,3200&amp;chd=t:5308,3629,2082,103,0,0,0,0,0,0,0,7612|3021,2249,1153,58,0,0,0,0,0,0,0,3048" alt="year to date chart" />
	<table> 
	<tr> 
		<th class="Month">Month</th> 
		<th class="Pages">Pages</th> 
		<th class="Hits">Hits</th> 
		<th class="Bandwidth">Bandwidth</th> 
		<th class="Visits">Visits</th> 
	</tr> 
		<tr> 
			<td>Jan</td> 
			<td>5,308</td> 
			<td>59,960</td> 
			<td>13.00 GB</td> 
			<td>3021</td> 
		</tr> 
		<tr> 
			<td>Feb</td> 
			<td>3,629</td> 
			<td>38,304</td> 
			<td>10.77 GB</td> 
			<td>2249</td> 
		</tr> 
		<tr> 
			<td>Mar</td> 
			<td>2,082</td> 
			<td>18,388</td> 
			<td>4.76 GB</td> 
			<td>1153</td> 
		</tr> 
		<tr> 
			<td>Apr</td> 
			<td>103</td> 
			<td>863</td> 
			<td>255.23 MB</td> 
			<td>58</td> 
		</tr> 
		<tr> 
			<td>May</td> 
			<td>0</td> 
			<td>0</td> 
			<td>0.00 KB</td> 
			<td>0</td> 
		</tr> 
		<tr> 
			<td>June</td> 
			<td>0</td> 
			<td>0</td> 
			<td>0.00 KB</td> 
			<td>0</td> 
		</tr> 
		<tr> 
			<td>July</td> 
			<td>0</td> 
			<td>0</td> 
			<td>0.00 KB</td> 
			<td>0</td> 
		</tr> 
		<tr> 
			<td>Aug</td> 
			<td>0</td> 
			<td>0</td> 
			<td>0.00 KB</td> 
			<td>0</td> 
		</tr> 
		<tr> 
			<td>Sept</td> 
			<td>0</td> 
			<td>0</td> 
			<td>0.00 KB</td> 
			<td>0</td> 
		</tr> 
		<tr> 
			<td>Oct</td> 
			<td>0</td> 
			<td>0</td> 
			<td>0.00 KB</td> 
			<td>0</td> 
		</tr> 
		<tr> 
			<td>Nov</td> 
			<td>0</td> 
			<td>0</td> 
			<td>0.00 KB</td> 
			<td>0</td> 
		</tr> 
		<tr> 
			<td>Dec</td> 
			<td>7,612</td> 
			<td>126,837</td> 
			<td>13.49 GB</td> 
			<td>3048</td> 
		</tr> 
</table>
</section> <!-- closes y2d section -->
<section id="daily">
	
</section>

<section id="errors" class="statsSection">
	<h2>Errors</h2>
	<table> 
		<tr> 
			<th class="Errors">Errors</th> 
			<th class="Type">Type</th> 
			<th class="Hits">Hits</th> 
			<th class="Bandwidth">Bandwidth</th> 
		</tr> 
		<tr> 
			<td>404<span class="moreInfo" data-jsondata="404">?</span></td> 
			<td>Not Found</td> 
			<td>70</td> 
			<td>21.00 KB</td> 
		</tr> 
		<tr> 
			<td>206<span class="moreInfo" data-jsondata="206">?</span></td> 
			<td>Partial Content</td> 
			<td>32</td> 
			<td>13.07 MB</td> 
		</tr> 
		<tr> 
			<td>301<span class="moreInfo" data-jsondata="301">?</span></td> 
			<td>Moved Permanently</td> 
			<td>20</td> 
			<td>6.22 KB</td> 
		</tr> 
		<tr> 
			<td>416<span class="moreInfo" data-jsondata="416">?</span></td> 
			<td>Requested Range Not Satisfiable</td> 
			<td>4</td> 
			<td>1.29 KB</td> 
		</tr> 
	</table>
</section> <!-- closes errors section -->
</div>


<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.5/jquery.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.11/jquery-ui.min.js"></script>
<script>
$(document).ready(function(){
	$("#tabNav a").click(function(){
		var sec = $(this).attr('href'),
			$sec = $(sec);
			
		if($sec[0].children.length == 0) {
			$.get({
				url:'funn/stats.php',
				data: {
					code:sec
				},
				success: function(d){
					console.log(d);
				}
			});
			console.log('no info')
		}
	});
});
</script>
</body>
</html>