<?php 
class nordlicht {
	public	$fi,
			$sec,
			$off =1;
	
	const arrayLimit = 800;
	protected	$sts = array(),
				$ss = array();



	/* builder()	- builds the whole stuff
	 *	returns 
	 */
	 
	function __construct(){


	}
	
	public function builder(){
		$this->sts = $this->openFile();
		$this->sectionArray();
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
	
	/* sectionArray()	- turns a section of the stats file array into a 2D array of values
	 *	$section		- the section you're looking for ex: TIME, DAY, ROBOT
	 *	$sts			- the stats file array
	 *	$off			- (optional) - offset for the header row - defaults to 1
	 *
	 *	return	= fully formated array of 
	 *	ex:		[Hour] => Array (
	 *				[0] => 0
	 *				[1] => 1
	 *				....
	 *				[22] => 22
	 *				[23] => 23
	 *			)
	 *			[Pages] => Array (
	 *				[0] => 128
	 *				[1] => 119
	 *				....
	 *				[22] => 150
	 *				[23] => 128
	 *			)
	 *			....
	 */
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
			$secE = $this->arrayFind('END_'.$section);	//the end of the section
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
		
		if(!$secArray):
			return false;
		endif;
		
		foreach($secArray as $sec2 => $s):
			$i = 0;
			while($i < $secHL):
				$time[rtrim($secHead[$i])][] = rtrim($s[$i]);
				$i++;
			endwhile;	//end $secHL while
			if($lim > self::arrayLimit):		//to keep memory usage down, if the array is longer then 800 lines, end it
				break;
			endif;
			$lim++;
		endforeach;	//end $secArray foreach
		
		return $this->ss=$time;
	}
}
?>