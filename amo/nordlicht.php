<?php 
/*===========================================
 #	nordlicht.php is part of nordlicht v3 Omaha
 #	author: stephen giorgi
 #	author email: stephen.giorgi@alphavega.com
 #	
 #	last change: 12.29.2011
 #	licensed under GNU GPLv2
 #	see licenses/gnu.txt for full text
 #
 #	Purpose: this file is the main class for dealing with the stats fext files
 #		it's required in order to open & parse the stats file
/*=========================================*/
class nordlicht {
	public	$fi,
			$sec,
			$off = 1,
			$perPage = 10,
			$browsers = array(),
			$cc = array();
	
	const arrayLimit = 1000;
	protected	$secS = 0, $secE = 0, $totalRows = 0,
				$secHead = array(),	$sts = array(),	$ss = array();

	/* builder()	- builds the whole stuff
	 *	returns 
	 */
	 
	function __construct(){


	}

	//second builder, makes it in json format
	public function builder(){
		$this->sts = $this->openFile();
		if($this->sec == "BROWSER"):
			self::sectionBrowser();
		else:
			self::sectionArray();
		endif;
	}

	/* destroy()	- empties the memory by making the main arrays return to empty arrays
	 *	return		= empty arrays
	 */
	public function destroy(){
		$this->sts = array();
		$this->ss = array();
	}
	
	/* openFile()	- opens the file from the AWstats dir
	 *	return 		= an array of that file's contents
	 */
	private function openFile(){
		return file($this->fi);
	}
	
	
	/* arrayFind()	- searchs array for partial strings
	 *	$needle		- string to search for
	 *	$haystack	- array to search
	 *	$search_keys
	 *	return 		- the array value of the string or false
	 */
	public function arrayFind($needle,$search_keys = false) {
		$haystack = $this->sts;
		if(!is_array($haystack)) :
			return false;
		endif;
		foreach($haystack as $key=>$value) :
			$what = ($search_keys) ? $key : $value;
			if(strpos($what, $needle)!==false) :
				return $key;
			endif;
		endforeach;
		
		return false;
	}
	
	public function sectionBounds(){
		$section = $this->sec;
		$sts = $this->sts;
		$off = $this->off;
		
		if($section == 'URL'):	//since there are two sections that start with SIDER, URL needs to be different
			$secS = $this->arrayFind('# URL - ');
			$secE = $secS+3 + substr($sts[$secS+2],12);
			$j= $secS+3;
			$off = 0;
		else:
			$secS = $this->arrayFind('BEGIN_'.$section);	//the begining of the section
			$secE = $this->arrayFind('END_'.$section);		//the end of the section
			$j = $secS + 1;
		endif; //end URL if
		
		$this->secS = $secS;
		$this->secE = $secE;
		$this->totalRows = $secE - $secS;
		$this->secHead = explode(' - ',substr($sts[$secS-$off],2));	//the headers
	}
	
	public function sectionBrowser(){
		self::sectionBounds();
		$sts = $this->sts;
		$off = $this->off;
		$j = $this->secS + 1;
		$secE = $this->secE;
		$total = $this->totalRows;
		$browsers = $this->browsers;
		$secHead = $this->secHead;
		$everyBrowser = array();
		$minorBrowsers = array();
		$majorBrowsers = array();
		
		$children = array();
		$i = 0;

		while($j < $secE) :
			$secExp = explode(' ',$sts[$j]);
			$brow = trim($secExp[0]);
			$hits = ($secExp[1]);
			$k = 0;

			array_push($everyBrowser,$brow);
			$version = explode(".",$brow);
			$bVersion = $version[0];
			/* firefox & opera use minor versions
				Firefox only used minor version up to v4.
				And even then they were perdictable 0.5, 0.6
				so we only filter on those greater then 0.4
			*/
			if((preg_match("/firefox/",$bVersion) && $version[1] > 4) || preg_match("/opera/",$bVersion)):
				$bVersion .= ".".$version[1];
			endif;

			$numChilds = count($children);
			$nc = 0;
			//if the minorVersion doesn't exist in the array, put it there
			if(array_search($bVersion,$minorBrowsers) === false):
				array_push($minorBrowsers,$bVersion);
				$newChild = array("name"=>$bVersion,"hits"=>$hits);
				array_push($children,$newChild);
			else:
				while($nc < $numChilds):
					if($children[$nc]["name"] == $bVersion):
						$children[$nc]["hits"] += $hits;
					endif;
					$nc++;
				endwhile;
			endif;

			
			$mVersion = preg_split("/[0-9]{1}/",$brow);
			$mv = trim($mVersion[0]);
			$numMaster = array_search($mv,$majorBrowsers);
			if($numMaster === false):
				array_push($majorBrowsers,$mv);
			else:
				
			endif;
			
			$j++;	//j is the line in the file so this doesn't necessarialy start at 0
			$i++;	//i ALWAYS starts at 0
			//if the limit is reached end the loop to keep memory down
			if($i > self::arrayLimit):
				$j = $secE + 1;
			endif;
		endwhile; //end $secE while

		$numBrows = count($majorBrowsers);
		$nb = 0;
		$secArray2 = array();

		while($nb < $numBrows):
			//the major browser name
			$mbn = $majorBrowsers[$nb];
			$childBrowsers = array();
			foreach($children as $newVersion):
				$mmv = preg_split("/[0-9]{1}/",$newVersion['name']);

				if($mbn == $mmv[0]):
					array_push($childBrowsers,$newVersion);
				endif;
			endforeach;
			$finalVersion = array("name"=>$mbn,"children"=>$childBrowsers);
			$secArray2[$nb] = $finalVersion;
			$nb++;
		endwhile;	//end nb < numBrows loop

		return $this->ss=$secArray2;
	}

	/////////////////////////////////
	public function sectionArray(){
		$section = $this->sec;
		$sts = $this->sts;
		$off = $this->off;
		
		if($section == 'URL'):	//since there are two sections that start with SIDER, URL needs to be different
			$secS = $this->arrayFind('# URL - ');
			$secE = $secS+3 + substr($sts[$secS+2],12);
			$j= $secS+3;
			$off = 0;
		else:
			$secS = $this->arrayFind('BEGIN_'.$section);	//the begining of the section
			$secE = $this->arrayFind('END_'.$section);		//the end of the section
			$j = $secS + 1;
		endif; //end URL if

		$i = 0;
		$secHead = explode(' - ',substr($sts[$secS-$off],2));	//the headers

		$secArray2 = array();

		while($j < $secE) :
			$secExp = explode(' ',$sts[$j]);
			$k = 0;
			foreach($secExp as $row):
				$val = trim(strtolower(str_replace(" ","",$secHead[$k])));
				$rowV = trim($row);
				if($val == "date"):
					$srtTime = strtotime($rowV);
					$fullDate = getdate($srtTime);
					$fullDate['iso'] = date("c",$srtTime);
					$secArray2[$i]["prettydate"] = date('l, \t\h\e jS', $srtTime);
					$secArray2[$i]["weekday"] = date('l', $srtTime);
					$secArray2[$i]["fulldate"] = $fullDate;
				elseif($val == "lastvisit"):
					$secArray2[$i]["prettylastvisit"] = date('M. d, Y', strtotime($rowV));
				endif;
				if($val == "domain"):
						$secArray2[$i]['prettycountry'] = $this->cc[strtoupper($rowV)];
						$secArray2[$i]['countrycode'] = $this->ccc[strtoupper($rowV)];
				endif;
				$secArray2[$i][$val] = $rowV;
				$k++;
			endforeach;
			$secArray2[$i]["id"] = "".$i."";
			$j++;	//j is the line in the file so this doesn't necessarialy start at 0
			$i++;	//i ALWAYS starts at 0
			if($i > self::arrayLimit):
				$j = $secE + 1;
			endif;
		endwhile; //end $secE while
		
		return $this->ss=$secArray2;
	}
	
	public function buildTable(){
		$table = $this->ss;
		$tableNode = '<table id="'.$this->sec.'">';
		$n = 0;
		foreach($table as $row):
			$tr = "\n\t<tr>";
			$th = "\n\t<tr>";
			if($n == 0):
				foreach($row as $cell=>$value):
					$th .= "\n\t\t<th>".$cell."</th>";
				endforeach;
				$th .= "\n\t</tr>";
				$tableNode .= $th;
			endif;
			$n++;
			
			foreach($row as $cell=>$value):
				$tr .= "\n\t\t<td>".$value."</td>";
			endforeach;
			$tr .= "\n\t</tr>";
			$tableNode .= $tr;
		endforeach;
		
		$tableNode .= "\n</table>";
		
		echo $tableNode;
	}
	
	public function sendJSON(){
		$data = array();
		$numRows = count($this->ss);
		
		$data["records"] = $numRows;
		$data["rows"] = $this->ss;
		$data["pages"] = ceil($numRows / $this->perPage);
		
		echo json_encode($data);
	}
	
	public function sendPrettyArray(){
		echo "<pre>";
		print_r($this->ss);
		echo "<pre>";
		
	}
}
?>