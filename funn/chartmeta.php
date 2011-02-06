<?php
/*###############
	@1.0 - Google Chart API url metadata
###############*/
$hourMetaC = array('cht'=>'bvg',//'chf'=>'c,lg,0,EFEFEF,0,BBBBBB,1',
   				   'chtt'=>'Hourly+Breakdown',
   				   'chdl'=>'Pages|Hits',
				   'chs'=>'800x350',
				   'chco'=>'80C65A,76A4FB',
				   'chma'=>'15,15,15,15|0,25',
				   'chg'=>'0,10,20,10',
   				   'chxt'=>'y,r,x',
				   'chxr'=>'0,0,'.findMax($time,'Pages').'|1,0,'.findMax($time,'Hits'),
				   'chxs'=>'0,80C65A,11.5,0,l,676767|1,76A4FB,11.5,0,l,676767',
				   'chbh'=>'a,0,9',
				   'chdlp'=>'b',	//legend position
				   'chds'=>'0,'.findMax($time,'Pages').',0,'.findMax($time,'Hits')				   
				   );

$monthMetaC = array('cht'=>'lc',					//chart type
					'chtt'=>'Daily+Breakdown',		//chart title
					'chdl'=>'Hits|Pages|Visits',	//legend labels
					'chs'=>'950x300',				//chart size
					'chco'=>'3072F3,80C65A,AA0033',	//data colors
					'chls'=>'4|2|1,5,5',		//line widths
					'chma'=>'40,20,30,50|0,25',	//margin
					'chg'=>'4,0,10,10',		//grid lines
					'chxtc'=>'3,10',		//axis tic marks
					'chxt'=>'y,y,r,x',	//axis
					'chxs'=>'0,AA0033,11.5,0,l,676767|1,80C65A,10.5,0,lt,676767|2,3072F3,11.5,-0.5,lt,676767|3,676767,11.5,0,lt,676767',	//axis styles
					'chds'=>'0,'.findMax($month,'Hits').',0,'.findMax($month,'Pages').',0,'.findMax($month,'Visits'),						//axis min & max
					'chxr'=>'0,0,'.findMax($month,'Visits').'|1,0,'.findMax($month,'Pages').'|2,0,'.findMax($month,'Hits').'|3,1,'.count($month['Hits']),//axis range
					'chdlp'=>'b'	//legend position
					);

$browserMeta = array('cht'=>'p3',	//pie chart
					 'chs'=>'450x250',	//size
					 'chma'=>'0,50,0,30|5',	//margins
					 'chtt'=>'Browser+Breakdown+(All+Versions)',	//title
					 'chts'=>'EFEFEF,13',					 //chart title color
					 'chf'=>'bg,lg,270,525252,0,2B323F,1',	//background
					 'chxt'=>'x',
					 'chxs'=>'0,E5ECF9,11.5',
					 'chp'=>'45',
					 'chco'=>'F64D00|80C65A|FFFF88|3072F3|AA0033|C2BDDD',	//colors
					 'chl'=>'Firefox|Chrome|Safari|Internet+Explorer|Opera|Other',	//chart legend labels
					 'chdlp'=>'b',	//chart legend placement
					 'chds'=>'0,'.max($ffSum,$chromeSum,$safariSum,$ieSum,$operaSum,$otherSum).'',
 					 'chdl'=>'Firefox|Chrome|Safari|Internet+Explorer|Opera|Other',		//chart data labels
					 'chd'=>'t:'.$ffSum.','.$chromeSum.','.$safariSum.','.$ieSum.','.$operaSum.','.$otherBrSum//chart data
					 );

$osMeta = array('cht'=>'p3',
				'chs'=>'450x250',
				'chma'=>'15,45,0,30|0,25',
				'chtt'=>'OS+Breakdown+(All+Versions)',
				'chts'=>'EFEFEF,13',
				'chf'=>'bg,lg,270,525252,0,2B323F,1',
				'chxt'=>'x',
				'chxs'=>'0,E5ECF9,11.5',
				'chp'=>'50',
				'chco'=>'224499|EFEFEF|AA0033|008000',
				'chdl'=>'Windows|Mac+OSX|Linux|Other%2FUnknown',
				'chl'=>'Windows|Mac+OSX|Linux|Other%2FUnknown',
				'chdlp'=>'b',
				'chds'=>'0,'.max($winOS,$macOS,$linuxOS,$otherOS),
				'chd'=>'t:'.$winOS.','.$macOS.','.$linuxOS.','.$otherOS
				);
$ccMap	= array('cht'=>'map:fixed=-60,180,80,179',
		'chs'=>'570x450',
		'chld'=>rtrim($domainData2['Domain'],'|'),
		'chdl'=>rtrim($domainData2['CC'],'|'),
		'chdlp'=>'b',
		'chco'=>'EFEF82|3072F3|AA0033|1B8F21|FF5200|452278|FF4600|58BECB|FF6CA2|82C782|C46AFB|FF9064|0FABCA|A6EE4B|CAC00B',
		'chf'=>'bg,s,9BC0D4',
		'chtt'=>'Top+10+Countries+by+Hits',
		'chm'=>rtrim($domainData2['Hits'],'|'),
		'chma'=>'30,20,0,10|0,25'
		);


$filesMetaC = array('cht'=>'bhs',
   				   'chtt'=>'Files+Types',
   				   'chdl'=>'Files',
				   'chs'=>'800x350',
				   'chco'=>'80C65A,',
				   'chma'=>'15,15,15,15',
				   'chg'=>'0,10,20,10',
   				   'chxt'=>'y,r,x',
				   'chxr'=>'0,0,'.findMax($files,'Hits'),
				   'chxs'=>'0,80C65A,11.5,0,l,676767|1,76A4FB,11.5,0,l,676767',
				   'chbh'=>'a,0,9',
				   'chdlp'=>'b',	//legend position
				   'chds'=>'0,'.findMax($files,'Hits')
				   );
$dtTotalMetaC = array('chxl=0:|Monday|Wednesday|Friday|Sunday',
					'chxp=0,0,2,4,6',
					'chxr=0,0,7|1,0,'.findMax($dtTM,'Pages'),	//axis maximums, need to make this dynamic for number of Pages.
					'chxs=0,676767,11.5,0,lt,676767|1,3366CC,11.5,0,l,676767',
					'chxt=x,y',
					'chbh=a,2,17',
					'chs=375x300',
					'cht=bvg',
					'chco=3072F3,80C65A,AA0033',	//data colors
					'chds=0,1477,0,21072,0,511',
					'chdl=Pages|Hits|Visits',
					'chdlp=b',
					'chg=0,10,0,0',
					'chma=10,10,5,25|0,25',
					'chm=D,8BACEE,0,-1.1,3|D,83E74C,1,-1,3,1|D,F57199,2,-1,3,-1',
					'chtt=Daily+Totals'
					);
$dtAverageMetaC = $dtTotalMetaC;
$dtAverageMetaC[2] = 'chxr=0,0,7|1,0,'.findMax($dtAM,'Pages');	//axis maximums, need to make this dynamic for number of Pages.
$dtAverageMetaC[15] = 'chtt=Daily+Averages';
?>