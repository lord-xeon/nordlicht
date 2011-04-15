<?php
require_once('nordlicht.php');
require_once('../../funn/funnns.php');
class Sherman extends nordlicht {
	public	$tableMeta = array(),
			$meta = array(),
			$checked = array(),
			$limit = false,
			$sort = false,
			$wordSizes = 1,
			$offSet = 0;

	private $hRows = '',
			$iRows = '';
			

	
	function __construct(){
		parent::__construct();
		
	}
	function __destruct(){
		$this->destroy();
	}
	
	public function builder(){
		parent::builder();
		$this->buildTable();
	}
	
	
	
	public function destroy(){
		parent::destroy();
		$this->hRows = $this->iRows = '';
		$this->tableMeta = array();
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
	
	public function buildTable(){
		$this->innerTable();
		echo "<table class=\"nStats\">\n";
		echo $this->headerRow($this->tableMeta,$this->checked);
		echo $this->iRows;
		echo "</table>\n";
	}
	
	public function innerTable(){
		$row = '';
		foreach($this->ss['Bandwidth'] as $id=>$v):
			if($id >= $this->offSet):
				if($j >= $this->limit && $this->limit != false):
					break;	//limit reached, stop loop
				endif;
				$row .= "\t<tr>\n";
				foreach($this->tableMeta as $h):
					//print_r($this->ss[$h]);
					$vl = $this->ss[$h][$id];
					
					switch($h):
						case 'Files type':			//add the file type icon to the cell
							$vl = '<img src="funn/img/files/file_'.$vl.'.png" alt="file icon" width="24" height="24" />'.$vl;	
							break;
						case 'Bandwidth':			//format the bandwidth to KB/MB/GB
							$vl = byteSize($vl);
							break;
						case 'Last visit date':		//format the date to Month DD, YYYY
							$vl = dayMake($vl);
							break;
						case 'Last visit' :
							$vl = dayMake($vl);
							break;
						case 'Date' :
							$vl = dayMake($vl);
							break;
						case 'Pages':				//add commas in the right places to make the number easier to read
							$vl = number_format($vl);
							break;
						case 'Hits':
							$vl = number_format($vl);
							break;
						case 'Visits':
							$vl = number_format($vl);
							break;
						default:
							$vl = $vl;
							break;
					endswitch;
					$row .= "\t\t<td>".$vl."</td>\n";
				endforeach;
				$row .= "\t</tr>\n";
				$j++;
			endif;
		endforeach;
		
		return $this->iRows = $row;
	}
	
	
	public function drawTable($args){
		
//		'section'=>$time;
//		'meta'=>$timeMetaT;
	
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
		
		
		
		//begin to draw the table
		
		foreach($section[$sort] as $id=>$v):
			if($id >= $offSet):
				if($j >= $limit && $limit != false):
					break;	//limit reached, stop the loop
				endif;
				echo "\t\t<tr>\n";
				foreach($args['meta'] as $h):
					$vl = $section[$h][$id];
					if($h == 'Files type'):
						
					elseif($h == 'Bandwidth'):
						$vl = byteSize($vl);
					elseif($h == 'Hits' || $h == 'Pages'):
						$vl = number_format($vl);
					elseif($h == 'Domain'):
						$vl = '<img src="funn/img/country/'.$vl.'.png" alt="'.$vl.'" width="16" height="11"/>'.str_replace('+',' ',$cc[strtoupper($vl)]);
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
						$vl = "<img src=\"funn/img/browsers/".strtolower(str_replace(' ','-',$vl)).".png\" alt=\"".$vl."\"/>".$vl;
					elseif($h == 'Errors'):
						$vl .= '<span class="moreInfo" data-jsondata="'. $vl .'">?</span>';
						if($vl == '404'):
							$vl .= fullRangeLink('sider_404');
						endif;
					endif;	//ends meta type if
					echo "\t\t\t<td>".$vl."</td>\n";
				endforeach;	//ends meta foreach
				echo "\t\t</tr>\n";
				$j++;
			endif;	//ends offset if
		endforeach;	//ends section foreach
		echo "</table>\n";
	}
	
	/* headerRow()	- prints out the header row for the tables - used inside tableMeta(), and todayStats() function
	 * $meta		- the metadata array for that section
	 * return		= header row in HTML table format
	 */
	public function headerRow($meta,$checked){
		echo "\t<tr>\n";
		$i = 0;
		$th = '';
		foreach($meta as $h):
			$th .= "\t\t".'<th class="'. str_replace(' ','-',$h).'" ';
			if(is_array($checked[$h]) && $checked):
				$thd = 'data-chartid="' . ($i + 1) . '" ';
				foreach($checked[$h] as $vl=>$type):
					if(is_array($type)):
						$thd .= 'data-charttypeops="true" ';
						foreach($type as $sub=>$subtype):
							$thd .= 'data-typeop-'.$sub.'="'.$subtype.'" ';
						endforeach;
					endif;
					$thd .= 'data-chart'.$vl.'="'.$type.'" ';
				endforeach;
				$th .= $thd;
			endif;
			$i++;
			$th .= '>'. $h ."</th>\n";
		endforeach;
		echo $th;
		echo "\t</tr>\n";
	}

	
	public function wordCloud(){
		$searchWhat = ' Searched Words';
		if($this->sec == 'SEARCHWORDS'):
			$searchWhat = ' Searched Phrases';
		endif;
		echo '<h2>Top '.$this->limit .$searchWhat . "</h2>\n";
		echo '<div class="wordCloud" id="'.$this->sec.'">'."\n";
		parent::builder();
		arsort($this->ss['Number of search']);
		$sss = $this->ss;	//cache the stats array
		$max = $sss[$this->meta[1]][0];
		$sum = array_sum($sss['Number of search']);
		$i = 0;
		$vls = '';
		foreach($sss['Number of search'] as $v => $vg):
			//if the search is equal to or over the limit end the loop
			if($i >= $this->limit):
				break;
			endif;
			
			$word = $sss[$this->meta[0]][$v];	//cache the word
			$word = str_replace('+',' ', $word);	//replace "+" with a space
			$num = $sss[$this->meta[1]][$v];	//cache the number
			$vl = round(($num / $max), $this->wordSizes);	//calculate the percentage of how this search term compares to the most searched term, round it to 1 decimal place by default

			//sets up the word cloud level variable which is relative to the max search value
			if($vl == 1) :	//the max level
				$wcl = 'max';
			elseif($vl == 0) :	//the lowest level
				$wcl = 0;
			else:	//the in between levels
				$wcl = substr($vl,2,$this->wordSizes);
			endif;
			$per = round(($num / $sum) *100, 1);
			$vls .= "\t".'<span class="wordCloud-'. $wcl .'" data-searchvalue="'.$num.'" data-searchpercent="'.$per.'">'.$word."</span>\n";
			$i++;
		endforeach;
		
		echo $vls;
		echo "</div>\n";
	}
}

?>