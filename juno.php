<?php require_once("funn/header.php"); 
	if($sts != false): 	?>
<div id="statsInfo">
	<section id="today" class="statsSection"> 
		<h2>Month to Date</h2>
		<div id="todayStats">
			<?php $lu = $general['LastUpdate'];
				lastUpdate($lu);
				echo "<p>". number_format($general['TotalVisits'][0]). " total visits this month</p>\n";
				echo "<p>".number_format($general['TotalUnique'][0]). " total uniques this month</p>\n"; ?>
		</div>
		<hr class="clear"/>
		<h2>Year to Date</h2>
		<img src="<?php echo chartURL($y2dMetaC,$y2d,$y2dMetaCc);?>" alt="year to date chart" />
		<?php drawTable($monthYearArgs);;?>
	</section> <!-- closes today section --> 
	
	<section id="daily" class="statsSection">
		<h2>Daily Breakdown</h2>
		<div id="dailyTotal">
			<img src="<?php echo dayChartURL($dtT,$dtTotalMetaC);?>" title="Daily Totals chart" />
			<h3>Daily Totals</h3>
			<?php dayTable($dt['Total']);?>
		</div> <!-- closes dailyTotal div-->
		<div id="dailyAvg">
			<img src="<?php echo dayChartURL($dtA,$dtAverageMetaC);?>" title="Daily Averages chart" />
			<h3>Daily Averages</h3>
			<?php dayTable($dt['Average']);?>
		</div> <!-- closes dailyAvg div-->
		<br class="clear" />
	</section> <!-- closes daily section -->
	 
	<section id="hours" class="statsSection"> 
		<h2>Hourly Breakdown</h2> 
		<img src="<?php echo chartURL($hourMetaC,$hourData,$hourCols);?>" alt="hour chart"/>
		<div class="tableHold">
			<?php drawTable($time12Args);
				drawTable($time24Args);?>	
			<br class="clear"/>
		</div> <!-- closes tableHold div --> 
	</section> <!-- closes hours section --> 
	 
	<section id="month" class="statsSection"> 
		<h2>Month to Date</h2>
		<img src="<?php echo chartURL($monthMetaC,$monthData,$monthCols);?>" alt="month to date line chart" />
		<div class="tableHold">
			<?php drawTable($month15Args);
				if(count($month['Date']) > 15):
					drawTable($month30Args);
				endif; ?>
		<br class="clear"/>
		</div> <!-- closes tableHold div -->
	</section> <!-- closes month section --> 
	
	<section id="browserOS" class="statsSection"> 
		<div id="browser" class="tableHold"> 
			<h2>Top Browsers</h2> 
			<img src="<?php echo chartURL($browserMeta,'','');?>" alt="browser breakdown pie chart" />
			<?php drawTable($browserArgs); ?>
			<br class="clear" />
		</div> <!-- closes broswer div --> 
		<div id="os" class="tableHold"> 
			<h2>Top Operating Systems</h2> 
			<img src="<?php echo chartURL($osMeta,'','');?>" alt="browser breakdown pie chart" />
			<?php drawTable($osArgs); ?>
			<br class="clear" />
		</div> <!-- closes os div --> 
	</section> <!-- closes browseOS section -->
	
	<section id="domainIP" class="statsSection"> 
		<div class="tableHold">
			<?php if($domain['Domain'][0] == 'ip'):
					echo 'Please install the <a href="http://awstats.sourceforge.net/docs/awstats_contrib.html#plugin_others" title="GeoIP">GeoIP plugin</a>.';
				else: ?>
			<h2>Top 15 Countries</h2>
			<img src="<?php echo chartURL($ccMap,'','');?>" alt="world chart" />
			<?php endif;
				drawTable($domainArgs); ?>
			<h2>Top 10 IPs</h2>
			<?php  drawTable($ipArgs);?>
			<br class="clear" />
		</div> <!-- closes tableHold div --> 
	</section> <!-- closes domainIP section -->
	
	<section id="content" class="statsSection">
		<div class="tableHold">
			<aside id="files">
				<h2>File Types</h2>
				<?php drawTable($fileArgs); ?>
			</aside>
			<aside id="pages">
				<h2>Top 15 Pages</h2> 
				<?php drawTable($pagesArgs); ?>
			</aside>
			<br class="clear" />
		</div> <!-- closes tableHold div -->
	</section> <!-- closes content section -->
	
	<section id="reffs" class="statsSection"> 
		<h2>Robots &amp; Refferals</h2>
			<?php drawTable($searchArgs); ?>
		<br class="clear" />
		<div class="tableHold">
			<aside id="se">
				<h2>Top 15 Search Engines</h2>
				<?php if($searchRef):
					drawTable($refArgs);
					else:
						echo 'No Search Engine refferals this month';
					endif;?>
			</aside>
			<aside id="robots">
				<h2>Robots</h2>
				<?php drawTable($robotArgs);	?>
			</aside>
			<br class="clear" />
		</div> <!-- closes tableHold div -->
	</section> <!-- closes reffs section -->
	
	<section id="searches" class="statsSection">
		<h2>Searches</h2>
		<div class="tableHold">
			<aside id="searchPhrase">
				<h2>Top 10 Search Phrases</h2>
				<?php if($searchPhrase):
					drawTable($searchPArgs);
					else:
						echo 'No Searches this month';
					endif;?>
			</aside> <!-- closes searchPhrase div --> 
			<aside id="searchWord">
				<h2>Top 10 Search Words</h2>
				<?php if($searchWord):
					drawTable($searchWArgs);
					else:
						echo 'No Searches this month';
					endif;?>
			</aside> <!-- closes searchPhrase div --> 
			<br class="clear"/>
		</div> <!-- closes tableHold div -->
	</section> <!-- closes searches section -->
	
	<section id="errors" class="statsSection">
		<h2>Errors</h2>
		<?php drawTable($errorArgs); ?>
	</section> <!-- closes errors section -->
</div> <!-- closes statsInfo div -->
<?php 
else:
	echo 'invalid file';
endif;
include("funn/footer.php"); ?>