<?php
/*Data file for AWstats*/
$general	= generalSts($sts);
$time		= sectionArray('TIME',$sts);
$month		= sectionArray('DAY',$sts);
$IPs		= sectionArray('VISITOR',$sts,3);
$domain		= sectionArray('DOMAIN',$sts,2);
$session 	= sectionArray('SESSION',$sts);
$dt			= dayTotals($month);
$dtT 		= dayChartData($dt['Total']);	//day total
$dtA 		= dayChartData($dt['Average']);	//day average
$dtTM 		= expandDay($dtT);				//day Total max
$dtAM 		= expandDay($dtA);				//day Average max
/*Data for the graphs*/
$hourData = chartData($time,$timeMetaT);
$monthData = chartData($month,$monthMetaT);
$domainData2 = ccMapData($domain,$domainMetaT,15,$cc);


/*Operating Systems*/
$os				= sectionArray('OS',$sts);
$oos = array_combine($os['OS ID'],$os['Hits']);
arsort($oos);
$osTotal = sumSec($os);
$winOS = sumOS($oos,'win');
$macOS = sumOS($oos,'mac');
$linuxOS = sumOS($oos, 'linux');
$otherOS = $osTotal - ($winOS+ $macOS+$linuxOS);
$osSec = array();
$osSec = osCombine('Windows',$winOS,$osTotal,$osSec);
$osSec = osCombine('Mac OS', $macOS,$osTotal,$osSec);
$osSec = osCombine('Linux (all)',$linuxOS,$osTotal,$osSec);
$osSec = osCombine('Other/Unknown',$otherOS, $osTotal,$osSec);

/*Browsers*/
$bro2 = sectionArray("BROWSER",$sts);
$broo = array_combine($bro2['Browser ID'],$bro2['Hits']);
arsort($broo);
$brTotal	= sumSec($bro2);
$ffSum 		= sumOS($broo,'fire');
$safariSum	= sumOS($broo,'safari');
$chromeSum	= sumOS($broo,'chrome');
$ieSum		= sumOS($broo,'msie');
$operaSum	= sumOS($broo,'opera');
$otherBrSum = $brTotal - ($ffSum + $safariSum + $chromeSum + $ieSum + operaSum);
$brSec = array();
$brSec = osCombine('Firefox',$ffSum,$brTotal,$brSec);
$brSec = osCombine('Chrome', $chromeSum,$brTotal,$brSec);
$brSec = osCombine('Safari',$safariSum,$brTotal,$brSec);
$brSec = osCombine('Internet Explorer',$ieSum, $brTotal,$brSec);
$brSec = osCombine('Opera',$operaSum, $brTotal,$brSec);
$brSec = osCombine('Other',$otherBrSum, $brTotal,$brSec);


/*Refferals*/
$robot 			= sectionArray('ROBOT',$sts,2);
$searchPhrase	= sectionArray('SEARCHWORDS',$sts,2);
$searchWord		= sectionArray('KEYWORDS',$sts,2);
$searchRef 		= sectionArray('SEREFERRALS',$sts);
$pageRef 		= sectionArray('PAGEREFS',$sts,2);

/*content*/
$files = sectionArray('FILETYPES',$sts);
$pages = sectionArray('URL',$sts);
arsort($files['Hits']);
$filesData = chartData($files,$filesMetaT);


/*Errors*/
$errors = sectionArray('ERRORS',$sts);
$e404	= sectionArray('SIDER_404',$sts);

?>