<?php
/*Config file for AWE stats
	Instlation:
	1. Put all files into a directory on your server.
	2. Update the path to the AWStats  data files
	3. Navigate to the directory on your domain adding stats-YOUR.DOMAIN.COM to the URL
	4. Enjoy
*/

$statsURL = $_GET['stats'];
$dayR = $_GET['time'];
$tday = date('mY');

//if the time is not specified, then use the current month and year
if($dayR==''):
	$dayR = date('mY');
endif;

/*nordlich version number*/
$nordlich  = '0.4';

/*Abslolute server path to AWStats data files*/
$stsP = '/var/lib/awstats/';

//default AWStats file name
$stsF = $stsP.'awstats'.$dayR.'.'.$statsURL.'.txt';

//domain
$domain = 'deadlycomputer.com';

//Year to date functionality, shows the monthly data from Jan. to Current month
$year2Date = true;
//year to date savefile directory by default it is in the funn/y2d/YEAR
$y2dDir = '/home/alphavega/demo/ph/nordlicht/funn/y2d/'.date('Y');
$y2d = $y2dDir .'/'.$statsURL.'.txt';

require_once('funnns.php');
//list of subdomains
$stsList = fileList($stsP);

//splash page check
if($_SERVER['PHP_SELF'] != 'nordlicht/index.php'):
	//sample AW stats output file
	if(file_exists($stsF)):
		$sts = file($stsF);
		require_once('metadata.php');
		require_once('data.php');
		require_once('chartmeta.php');
		require_once('tableArgs.php');
	else:
		$sts = false;
	endif;	
	//Year to date
	if($year2Date == true):
		require_once('funn/y2d/y2d-builder.php');
	endif;
endif;	//end splash page if
?>