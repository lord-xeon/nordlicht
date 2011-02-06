<?php
/*Config file for AWE stats
	Instlation:
	1. Put all files into a directory on your server.
	2. Update the path to the AWStats  data files
	3. Navigate to the directory on your domain adding stats-YOUR.DOMAIN.COM to the URL
	4. Enjoy
*/
//nordlich version number - current version of nordlicht
$nordlich  = '0.4';

//Abslolute server path to AWStats data files.  The usual path is below, but your server may differ
$stsP = '/var/lib/awstats/';

/* The AWstats filename structure.  By default AWStats saves the file as:
 * awstatsmmYYYY.domain.com.txt
 * if your filename structure is different, change it below*/
$stsF = $stsP.'awstats'.$dayR.'.'.$statsURL.'.txt';

//domain
$domain = 'deadlycomputer.com';

/*Year to date functionality, shows the monthly data from Jan. to Current month
 * change to false if you don't want the year to date functionality*/
$year2Date = true;

/* Absolute server path to the place you want the year to date savefile directory to be
 * This path does not need to be navigatable through the web.  It just needs to be writable via Apache
 * chmod -R 777 this directory */
$y2dDir = '/home/alphavega/demo/ph/nordlicht/funn/y2d/'.date('Y');

//Don't change stuff after this line unless you know what you're doing

//file naming structure of the year to date data files
$y2d = $y2dDir .'/'.$statsURL.'.txt';

require_once('funnns.php');

//list of subdomains
$stsList = fileList($stsP);

//splash page check - don't bother loading the data if we're only on the splash page
if($_SERVER['PHP_SELF'] != '/nordlicht/index.php'):
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
	//Year to date check
	if($year2Date == true):
		require_once('funn/y2d/y2d-builder.php');
	endif;
endif;	//end splash page if
?>