<?php
/*Functions file for AWstats*/

/* fileList()	- list the files in a directory, returns an array of them
	$dir		- path to directory
	
	return		= array of file list
*/
function fileList($dir){
	$stsList = array();
	if($handle = opendir($dir)):
		while(false !== ($file = readdir($handle))):
			if($file != "." && $file != ".."):
				$stss = explode('.',$file);
				$stsList[] = $stss[1].'.'.$stss[2].'.'.$stss[3];
			endif;
		endwhile;
	endif;
	closedir($handle);
	return $stsList;
}

/* fileDrop()	- makes a drop down of each item in the fileList() array
	$fileList	- list of files returned from fileList()
	
	return		= drop down of different files
*/
function fileDrop($fileList){
	echo '<select id="siteSelect" name="siteSelect">';
	$secList = array();
	foreach($fileList as $site):
		if(!in_array($site,$secList)):
			echo '<option id="'.$site.'" name="'.$site.'">'.$site.'</option>';
			$secList[] = $site;
		endif;
	endforeach;
	echo '</select>';
}


/*arrayFind()	- searchs array for partial strings
	$needle		- string to search for
	$haystack	- array to search
	$search_keys
	return 		- the array value of the string or false
*/
function arrayFind($needle, $haystack, $search_keys = false) {
	if(!is_array($haystack))
	{
		return false;
	}
	foreach($haystack as $key=>$value)
	{
		$what = ($search_keys) ? $key : $value;
		if(strpos($what, $needle)!==false) return $key;
	}
	return false;
}
/*byteSize()	- turns a number of bytes into a human readable value perfexed with KB/MB/GB
	$bytes		- input value
	
	return		= human readable value to 2 decimal places with KB/MB/GB added
*/
function byteSize($bytes) {
	$size = $bytes / 1024;
	if($size < 1024) {
		$size = number_format($size, 2);
		$size .= ' KB';
	} 
	else {
		if($size / 1024 < 1024) {
			$size = number_format($size / 1024, 2);
			$size .= ' MB';
		} 
		elseif ($size / 1024 / 1024 < 1024) {
			$size = number_format($size / 1024 / 1024, 2);
			$size .= ' GB';
		} 
	}
	return $size;
}
/*dayMake()		- turns a date [20100505] string into a human readable date [May 05, 2010]
	$section	- the string to turn into the day
	
	return		= String of the day with proper month
*/
function dayMake($section){
	$m = array('Jan.,','Feb.','March','April','May','June','July','Aug.','Sept.','Oct.','Nov.','Dec.');
	$year = substr($section,0,4);
	$month = substr($section,4,2);
	$day = substr($section,6,2);
	$date = $m[$month-1]. ' '.$day.', '.$year;
	return $date;
}

/*sectionArray()	- turns a section of the stats file array into a 2D array of values
	$section		- the section you're looking for ex: TIME, DAY, ROBOT
	$sts			- the stats file array
	$off			- (optional) - offset for the header row - defaults to 1
	
	return	= fully formated array of 
		ex:		[Hour] => Array (
					[0] => 0
					[1] => 1
					....
					[22] => 22
					[23] => 23
				)
				[Pages] => Array (
					[0] => 128
					[1] => 119
					....
					[22] => 150
					[23] => 128
				)
				....
				*/
function sectionArray($section,$sts,$off=1){
	if($section == 'URL'):	//since there are two sections that start with SIDER, URL needs to be different
		$secS = arrayFind('# URL - ',$sts);
		$secE = $secS+3 + substr($sts[$secS+2],12);
		$j= $secS+3;
		$off = 0;
	else:
		$secS = arrayFind('BEGIN_'.$section,$sts);	//the begining of the section
		$secE = arrayFind('END_'.$section,$sts);	//the end of the section
		$j = $secS+1;
	endif; //end URL if
	$i = 0;
	$secHead = explode(' - ',substr($sts[$secS-$off],2));	//the headers
	while($j < $secE) :
		$secArray[$i] = explode(' ',$sts[$j]);
		$j++;
		$i++;
	endwhile; //end $secE while

	$secHL = count($secHead);
	$lim = 0;
	foreach($secArray as $sec => $s):
		$i = 0;
		while($i < $secHL):
			$time[rtrim($secHead[$i])][] = rtrim($s[$i]);
			$i++;
		endwhile;	//end $secHL while
		if($lim > 800):		//to keep memory usage down, if the array is longer then 800 lines, end it
			break;
		endif;
		$lim++;
	endforeach;	//end $secArray foreach
	
	return $time;
}

/*generalSts()	- returns the general stats part of the stats file
	$sts		- the stats file array
	
	return 		= array
*/
function generalSts($sts){
	$genB = arrayFind('BEGIN_GENERAL',$sts);
	$genE = arrayFind('END_GENERAL',$sts);
	$j = $genB +1;
	$i = 0;
	while($j < $genE):
		$s = rtrim($sts[$j]);
		$n = explode(' ',$s);
		$gen[$n[0]] = array_slice($n,1);
		$j++;
	endwhile;
	$lus = arrayFind('# LastUpdate',$sts);
	$lu = explode(' - ',substr($sts[$lus],16));
	$g = count($gen['LastUpdate']);
	while($i < $g):
		$gen['LastUpdate'][rtrim($lu[$i])] = $gen['LastUpdate'][$i];
		unset($gen['LastUpdate'][$i]);
		$i++;
	endwhile;
	return $gen;
}

/*############
@2 - Tables
############*/
/*Function - headerRow()	- prints out the header row for the tables - used inside tableMeta(), and todayStats() function
	$meta		- the metadata array for that section
	
	return		= header row in HTML table format
*/
function headerRow($meta){
	echo "\t<tr>\n";
	foreach($meta as $h):
		echo "\t\t<th class=\"".str_replace(' ','-',$h)."\">".$h."</th>\n";
	endforeach;
	echo "\t</tr>\n";
}

/*Function - drawTable()	= draws a table for the section of the array  Takes an assocative array of arguments
	'section' 	= > section of the stats array file	(Required)
	'meta'		= > meta data for headers to draw	(Required)
	'limit'		= > the limit to print out
	'offSet'	= > when to offset the begining of the table - for Dual Tables ex: Hours 0-11, and Hours 12-23
	'sort'		= > how to sort the table
	'tableID'	= > id to give the <table> element (table[random 5-500] default)
	'cc'		= > array of information relative to one of the sections to display ex: turning US into United States
*/
function drawTable($args){
	//set the variables
	$section = $args['section'];
	$j = 0;
	
	$limit = false;
	if($args['limit']) :
		$limit = $args['limit'];
	endif;
	
	$offSet = 0;
	if($args['offSet']):
		$offSet = $j = $args['offSet'];
	endif;
	
	if($args['cc']):
		$cc = $args['cc'];
	endif;

	$sort = 'Bandwidth';
	if($args['sort']) :
		$sort = $args['sort'];
		arsort($section[$sort]);
	endif;
	
	$tableID = 'table'.rand(5,500);
	if($args['tableID']):
		$tableID = $args['tableID'];
	endif;
	
	//begin to draw the table
	echo "<table id=\"".$tableID."\">\n";
	headerRow($args['meta']);	//the header row
	
	foreach($section[$sort] as $id=>$v):
		if($id >= $offSet):
			if($j >= $limit && $limit != false):
				break;	//limit reached, stop the loop
			endif;
			echo "\t\t<tr>\n";
			foreach($args['meta'] as $h):
				$vl = $section[$h][$id];
				if($h == 'Files type'):
					$vl = '<img src="funn/img/files32/'.$vl.'.png" alt="file icon" width="32px" height="32px;" />'.$vl;
				elseif($h == 'Bandwidth'):
					$vl = byteSize($vl);
				elseif($h == 'Hits' || $h == 'Pages'):
					$vl = number_format($vl);
				elseif($h == 'Domain'):
					$vl = '<img src="funn/img/country/'.$vl.'.png" alt="'.$vl.'" width="16px" height="11px"/>'.str_replace('+',' ',$cc[strtoupper($vl)]);
				elseif($h == 'Last visit date' || $h == 'Last visit' || $h == 'Date'):
					$vl = dayMake($vl);
				elseif($h == 'URL'):
					$va = '<a href="http://'.$args['baseURL'].'/'.$vl.'">'.$vl.'</a>';
					$vl = $va;
				elseif($h == 'Search keyphrases'):
					$vl = str_replace('+',' ',$vl);
				elseif($h == 'External page referers'):
					$vl = '<a href="'.$vl.'" title="visit site">'.$vl.'</a>';
				elseif($h == 'Type'):
					$vl = $args['error'][$section['Errors'][$id]];
				elseif($h == 'Browser'):
					$vl = "\t\t<img src=\"funn/img/browsers/".strtolower(str_replace(' ','-',$vl)).".png\"alt=\"".$vl."\"/>".$vl."\n";
				endif;	//ends meta type if
				echo "\t\t\t<td>".$vl."</td>\n";
			endforeach;	//ends meta foreach
			echo "\t\t</tr>\n";
			$j++;
		endif;	//ends offset if
	endforeach;	//ends section foreach
	echo "</table>\n";
}


/*findMax()		- finds the max value for a section of the stats file array
	$section	- section of the stats file array
	$col		- the col to get the max from
	
	return		= max + 5%
*/
function findMax($section,$col){
	$max = 0;
	foreach($section[$col] as $s):
		if($s > $max):
			$max = $s;
		endif;
	endforeach;
	return round($max +($max*0.05));
}

/*chartData()	- makes Google Chart formated data from 
	$section	- section of the stats file array
	$meta		- table metadata array
	
	return		= array of values for each column from the metadata array
*/
function chartData($section,$meta,$limit=false){
	$i = 0;
	$data = array();
	$end = count($section[$meta[1]]);
	if($limit != false):
		$end = $limit;
	endif;
	while($i < $end):
		foreach($section as $s=>$f):
			$data[$s] .= $f[$i].',';
		endforeach;
		$i++;
	endwhile;
	return $data;
}

/*ccMapData()	- makes an array of the countries in the Google Chart API format
	$section	- section of the stats file array
	$meta		- chart columns
	$limit		- number of rows to graph
	$cc			- country code array
	
	return		= sorted array in Google Chart API format for Map chart
*/
function ccMapData($section,$meta,$limit,$cc){
	$j = 0;
	$data = array();
	arsort($section['Hits']);
	$colLim = count($section['Hits']);
	if($limit != false):
		$colLim = $limit;
	endif;
	foreach($section['Hits'] as $id=>$v):
		foreach($meta as $h):
			if($j >= $colLim):
				break;	//when the limit is reached, stop everything
			endif;
			$vl = $section[$h][$id];
			
			if($h == 'Domain'):
				$data[$h] .= strtoupper($vl).'|';
				$data['CC'] .= $cc[strtoupper($vl)].'|';
			elseif($h == 'Hits'):
				$data[$h] .= 'f'.$vl.'+Hits,000000,0,'.$j.',9|';
			else :
				$data[$h] .= $vl.',';
			endif;
		endforeach;	//ends meta foreach
		$j++;
	endforeach;	//ends section[sort] foreach

	return $data;
}

/*chartURL()	- builds the URL for the Google Chart API
	$meta		- the individual chart's metadata array
	$data 		- data returned from chartData()
	$metaD		- which columns to graph
	
	return		= URL to embed in an <img src="..." />
*/
function chartURL($meta,$data,$metaD){
	$url = 'http://chart.apis.google.com/chart?';
	foreach($meta as $v=>$f):
		$url .= "&amp;".$v."=".$f;
	endforeach;
	if($metaD != null):
		foreach($metaD as $c):
			$d .= rtrim($data[$c],',').'|';
		endforeach;
		$d ='&amp;chd=t:'. rtrim($d,'|');	
		$url .= $d;
	endif;
	
	return $url;
}


/*todayStats()	- prints out table of today stats as of: 
	$section	- takes the $month section of the stats file array
	$meta		- metadata for the headers
	
	return		= HTML table
*/
function todayStats($section,$meta){
	$t = count($section);
	echo "\n<table>\n";
	headerRow($meta);
	echo "\t<tr>\n";
	foreach($meta as $s):
		if($s == 'Bandwidth'):
			echo "\t\t<td>".byteSize($section[$s][$t])."</td>\n";
		elseif($s == 'Date'):
			echo "\t\t<td>".dayMake($section[$s][$t])."</td>\n";
		else:
			echo "\t\t<td>".$section[$s][$t]."</td>\n";
		endif;
	endforeach;
	echo "\t</tr>\n";
	echo "</table>\n";
}


/*################
Browse/OS totals
#################*/

/*sectionNull	- adds NULL to empty sections of the stats array - needed for the Visitors section because the last 2 values are not always logged
	$secArr		- the individual array of the section
	$secL		- the length of the header array

	return		= fully formated array with NULL inserted
*/
function sectionNull($secArr,$secL){
	$secL2 = count($secArr);
	if($secL2 < $secL):
		while($secL2 < $secL):
			$secArr[$secL2] = 'NULL';
			$secL2++;
		endwhile;
	endif;
	return $secArr;
}


/*sumSec()		- returns the sum of all the Hits for a stats file array section
	$section	- array section from the stats file
	
	return		= int of total hits
*/
function sumSec($section){
	$t = 0;
	foreach($section['Hits'] as $n):
		$t += $n;
	endforeach;
	return $t;
}


/*sumSecType	- returns the sum of Hits for each type
	$section 	- section of the stats file array
	$type		- type to sum up ex: Firefox, Windows
	
	return		= int of total for that type
*/
function sumSecType($section,$type){
	$sum = 0;
	$i = 0;
	while($i < 	count($section)):
		foreach($section[$i] as $s => $t):
			if(strpos($section[$i][$s],$type)):
				$sum = $sum + $section[$i]['Hits'];
			endif;
		endforeach;
		$i++;
	endwhile;
	return $sum;
}

/**/
function sumOS($section,$type){
	$val = 0;
	foreach($section as $s=>$g):
		if(strpos($s,$type)===0):
			$val = $val + $g;
		endif;
	endforeach;
	return $val;
}

/**/
function osCombine($type,$hits,$total,$atom){
	$n = 'Browser';
	if($type == 'Windows' || $type == 'Mac OS' || $type =='Linux (all)' || $type == 'Other/Unknown'):
		$n = 'Operating System';
	endif;
	$atom[$n][] = $type;
	$atom['Hits'][] = $hits;
	$atom['Percent Total'][] = round($hits/$total*100,2)." %";
	
	return $atom;
}


/*weekDay()*/
function weekDay($section){
	$week = array();
	$weekT = array('Week Day'=>'Sunday','Monday','Tuesday','Wednesday','Thursday','Friday','Saturday');
	$len = count($section['Date']);
	$i = 0;
	while($i < $len):
		$date = $section['Date'][$i];
		$y = substr($date,0,4);
		$m = substr($date,4,2);
		$d = substr($date,6,2);
		$ts = mktime(0,0,0,$m,$d,$y);
		$da = getdate($ts);		
		$dw = $da['weekday'];
		$week['weekDays'][] = $dw;
		$i++;
	endwhile;
	$ns = array_merge($week,$section);
	foreach($ns as $s=>$g):
		$j = 0;
		foreach($weekT as $wd):
			while($j < $len):
				if($g[$j] == $wd):
					echo 'True';
				endif;
				$j++;
			endwhile;
		endforeach;
	endforeach;
}

/*lastUpdate()	- last time the stats file was updated 
	$date 		- the LastUpdate section of the general array
	$ar			- return an array instead of the formated string (false by default)
	
	return		= formated string: "Last Updated: ....." or getdate() array
*/
function lastUpdate($section,$ar=false){
		$date = $section['Date of last update'];
		$numNew = $section['Nb of parsed new records'];
		$y = substr($date,0,4);
		$m = substr($date,4,2);
		$d = substr($date,6,2);
		$h = substr($date,8,2);
		$mm = substr($date,10,2);
		$s = substr($date,12,2);
		
		$dy = mktime($h,$mm,$s,$m,$d,$y);
		$da = getdate($dy);
		if($ar == true):
			return $da;
		endif;
		$am = 'a.m.';
		if($da['hours'] >12):
			$da['hours'] = $da['hours']-12;
			$am = 'p.m.';
		endif;
		$u = "<p><span class=\"bold\">Last Updated:</span> ";
		$u .= $da['weekday'].', '. $da['month'] . ' ' . $da['mday'] . ', '.$da['year'] . ' at: '. $da['hours'] . ':'.$da['minutes']. ' '.$am."</p>\n";
		$u .="<p> ". number_format($numNew) ." new records since last update.</p>\n";
		echo $u;
	}

?>