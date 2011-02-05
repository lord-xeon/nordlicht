<?php
require_once('y2d-class.php');

//checks to see if the current year dir is made, if not makes it
if(!is_dir($y2dDir)):
	mkdir($y2dDir,0777);
endif;

//checkse to see if the y2d file for the current site is made, if not makes an empty one
if(!file_exists($y2d)):
	y2dFile($y2d,$statsURL);
	echo 'year to date stats file written';
endif;


if(substr($dayR,2,4) != date('Y')):
	$y = new Y2D();		//starts the new class
	$y->month = substr($dayR,0,2);	//gets the month from the time
	$y->getCache($y2d);		//opens the Y2D file
	$y->getTotals($month);	//totals up the Pages, Hits, Bandwidth, and Visits for the current month
	$y->builder();			
	$y->writeCache($y2d);	//writes the file to disk
endif;

$y2dF = file($y2d);		//opens the y2d file array
$y2dA = sectionArray('MONTH',$y2dF);
$monthYearMeta = array('Month','Pages','Hits','Bandwidth','Visits');
$monthYearArgs = array('section'=>$y2dA,
						'meta'=>$monthYearMeta);
//year to month graph metadata
$y2dMetaC = array('chs'=>'600x300',
					'cht'=>'ls',
					'chtt'=>'Year+to+Date',
					'chf'=>'bg,lg,30,EFEFEF,0,616161,3|c,s,F8F5F5',	//chart background
					'chxl'=>'0:|Jan.|Feb.|Mar.|April|May|June|July|Aug.|Sept.|Oct.|Nov.|Dec.',	//bottom axis labels
					'chxr'=>'0,0,12|1,0,6000|2,0,300',
					'chxs'=>'2,EFEFEF,11.5,0,l,676767',
					'chxt'=>'x,y,r',
					'chdl'=>'Pages|Visits',
					'chdlp'=>'b',
					'chma'=>'10,10,10,10|0,25',	//chart margin
					'chg'=>'9,10',
					'chls'=>'2|2',
					'chm'=>'b,FFFF88,0,1,0,1',
					'chts'=>'C3D9FF,13.5',
					'chco'=>'008000,AA0033',
					'chds'=>'0,'.findMax($y2dA,'Pages').',0,'.findMax($y2dA,'Visits')	
);
$y2dMetaCc = array('Pages','Visits');	//chart columns
$y2dData = chartData($y2dA,$y2dMetaCc);	//chart data maker
?>