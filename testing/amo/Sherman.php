<?php
require_once('nordlicht.php');
require_once('../funn/funnns.php');

class Sherman extends nordlicht {
	public	$tableMeta = array(),
			$typeMeta = array(),
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
		$this->iRows = $this->innerTable();
		echo "<table class=\"nStats\">\n";
		echo $this->headerRow($this->tableMeta,$this->checked);
		echo $this->iRows;
		echo "</table>\n";
	}
	
	public function innerTable(){
		$row = '';
		$fe = 'Hits';
		if($this->sec == 'BROWSER' || $this->sec == 'ERRORS'){
			$fe = 'Hits';
		}
		arsort($this->ss[$fe]);
		foreach($this->ss[$fe] as $id=>$v):
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
						case 'Type':
							//
							$vl = $this->typeMeta[$vl];
							break;
						case 'Errors':
							//adds the more info ? next to each error
							$vl = $vl . '<span class="moreInfo" data-jsondata="'.$vl.'">?</span>';
							break;
						case 'Search engine referers ID':
							//replaces underscore with a space, and makes first letter of each word Upper Case
							$vl = ucwords(str_replace('_',' ',$vl));
							break;
						case 'External page referers':
							/* makes the refferal a link to that page with the nofollow attribute since thats what it is
							 * also truncates the link to characters long placing ... in the center
							 */
							$vl = '<a href="'.$vl.'" title="visit site" rel="nofollow" class="externalLinks">'.truncate($vl,50).'</a>';
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
function truncate($str,$max){
	$newStr = $str;
	$len = strlen($str);

	if($len > $max):
		$mid = $max / 2;
		$newStr = substr($str,0,($mid - 2));
		$newStr .= ' ... ';
		$newStr .= substr($str,($len - $mid + 2));
	endif;
	
	return $newStr;
}
?>