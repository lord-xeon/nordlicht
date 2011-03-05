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
		</div><!--closes todayStats div-->
		</section>

		<?php if($year2Date == true): //only print the year chart if year2Date is set to true?>
		<section id="year2Date" class="statsSection">
		<div id="y2d">
			<h2>Year to Date</h2>
			<img src="<?php echo chartURL($y2dMetaC,$y2dData,$y2dMetaCc);?>" alt="year to date chart" />
			<?php drawTable($monthYearArgs);
			echo "</div> <!-- closes y2d div-->\n";
			endif;?>
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
		<h3>Session Length</h3>
		<?php drawTable($sessionArgs);?>
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
			<h3>Top Browsers</h3>
			<img src="<?php echo chartURL($browserMeta,'','');?>" alt="browser breakdown pie chart" />
			<?php drawTable($browserArgs); ?>
			<br class="clear" />
		</div> <!-- closes broswer div -->
		<div id="os" class="tableHold">
			<h3>Top Operating Systems</h3>
			<img src="<?php echo chartURL($osMeta,'','');?>" alt="browser breakdown pie chart" />
			<?php drawTable($osArgs); ?>
		</div> <!-- closes os div -->
		<br class="clear" />
	</section> <!-- closes browseOS section -->
	
	<section id="domainIP" class="statsSection">
	<h2>Geo Location</h2>
		<div id="domain">
			<?php if($domain['Domain'][0] == 'ip'):
					echo 'Please install the <a href="http://awstats.sourceforge.net/docs/awstats_contrib.html#plugin_others" title="GeoIP">GeoIP plugin</a>.';
				else: ?>
			<h3>Top 15 Countries
				<?php fullRangeLink('Domain');?>
			</h3>
			<img src="<?php echo chartURL($ccMap,'','');?>" alt="world chart" />
			<?php endif;
				drawTable($domainArgs); ?>
				<br class="clear" />
		</div> <!-- closes domain div -->
		<div id="IP">
			<h3>Top 10 IPs
				<?php fullRangeLink('VISITOR');?>
			</h3>
			<?php  drawTable($ipArgs);?>
			<br class="clear" />
		</div> <!-- closes IP div --> 
	</section> <!-- closes domainIP section -->
	
	<section id="content" class="statsSection">
		<h2>Top Content</h2>
		<aside id="files">
			<h3>File Types
				<?php fullRangeLink('fileTypes');?>
			</h3>
			<?php drawTable($fileArgs); ?>
		</aside>
		<aside id="pages">
			<h3>Top 15 Pages</h3>
			<?php drawTable($pagesArgs); ?>
		</aside>
		<br class="clear" />
	</section> <!-- closes content section -->
	
	<section id="reffs" class="statsSection"> 
		<h2>Robots &amp; Refferals</h2>
			<?php fullRangeLink('pageRefs');
				drawTable($searchArgs); ?>
			<br class="clear" />
			<aside id="se">
				<h3>Top 15 Search Engines</h3>
				<?php if($searchRef):
					drawTable($refArgs);
					else:
						echo 'No Search Engine refferals this month';
					endif;?>
			</aside>
			<aside id="robots">
				<h3>Robots</h3>
				<?php drawTable($robotArgs); ?>
			</aside>
			<br class="clear" />
	</section> <!-- closes reffs section -->

	<section id="searches" class="statsSection">
		<h2>Searches</h2>
			<aside id="searchPhrase">
				<h3>Top 10 Search Phrases</h3>
				<?php if($searchPhrase):
					drawTable($searchPArgs);
					else:
						echo 'No Searches this month';
					endif;?>
			</aside> <!-- closes searchPhrase div --> 
			<aside id="searchWord">
				<h3>Top 10 Search Words</h3>
				<?php if($searchWord):
					drawTable($searchWArgs);
					else:
						echo 'No Searches this month';
					endif;?>
						</aside> <!-- closes searchPhrase div --> 
			<br class="clear"/>
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