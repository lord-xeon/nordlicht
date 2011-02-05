<?php
/*arguments for the generation of the tables*/

//year to date
$year2Date = array('section'=>sectionArray('MONTH',$cacheF),
						'meta'=>$year2DayMeta);

//Time - 0 - 11am
$time12Args 	= array('section'=>$time,
						'meta'=>$timeMetaT,
						'limit'=>12);
//Time - 12 - 23pm
$time24Args 	= array('section'=>$time,
					'meta'=>$timeMetaT,
					'offSet'=>12);
//Days of the Month - 1st - 15th
$month15Args 	= array('section'=>$month,
						'meta'=>$monthMetaT,
						'limit'=>15);
//Days of the Month - 16th - end
$month30Args 	= array('section'=>$month,
						'meta'=>$monthMetaT,
						'offSet'=>15);
//Browsers
$browserArgs	= array('section'=>$brSec,
						'meta'=>$brMetaT,
						'sort'=>'Hits');
//Operating Systems
$osArgs		= array('section'=>$osSec,
					'meta'=>$osMetaT,
					'sort'=>'Hits');
//coutries
$domainArgs	= array('section'=>$domain,
					'meta'=>$domainMetaT,
					'limit'=>15,
					'sort'=>'Hits',
					'cc'=>$cc);
//IPs
$ipArgs 	= array('section'=>$IPs,
					'meta'=>$IPMetaT,
					'limit'=>10,
					'sort'=>'Hits');
//file types
$fileArgs = array('section'=>$files,
					'meta'=>$filesMetaT,
					'limit'=>10,
					'sort'=>'Hits');
//Pages
$pagesArgs	= array('section'=>$pages,
					'meta'=>$pagesMetaT,
					'limit'=>15,
					'sort'=>'Pages',
					'baseURL'=>$statsURL);
//Search Words
$searchWArgs	= array('section'=>$searchWord,
						'meta'=>$searchWordMetaT,
						'limit'=>10,
						'sort'=>'Number of search');
//Search Phrases
$searchPArgs= array('section'=>$searchPhrase,
					'meta'=>$searchPhraseMetaT,
					'limit'=>10,
					'sort'=>'Number of search');
//Robots
$robotArgs = array('section'=>$robot,
					'meta'=>$robotMetaT,
					'limit'=>10,
					'sort'=>'Hits');
//Search Refferals
$searchArgs = array('section'=>$pageRef,
					'meta'=>$pageRefMetaT,
					'sort'=>'Pages',
					'limit'=>15);
//Refferals
$refArgs 	= array('section'=>$searchRef,
					'meta'=>$searchRefMetaT,
					'sort'=>'Hits',
					'limit'=>15);
//Errors
$errorArgs = array('section'=>$errors,
					'meta'=>$errorMetaT,
					'sort'=>'Hits',
					'error'=>$apacheStatusCode);
?>