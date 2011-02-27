<?php 
/*Class FullRange
	gets the full range of values in the stats file for a given section
*/
class FullRange {
	public $surl,	//subdomain
		$dayR,	//time
		$sts,	//stats file array
		$what,	//section to search for
		$secS,	//begining of searched for section
		$secE,	//end of searched for section
		$jsonObj =  array();
	
	private $url = '/var/lib/awstats/',	//absolute server path to stats file
		$secOff= array('VISITOR'=>3,'DOMAIN'=>2,'FILETYPES'=>1,'PAGEREFS'=>2);
	
	//opens the file
	private function openFile(){
		$url .= $this->url.'awstats'.$this->dayR.'.'.$this->surl.'.txt';
		$this->sts = file($url);
		return $this->sts;
	}
	
	//searchs an array for the needle
	private function arrayFind($needle,$search_keys=false){
		if(!is_array($this->sts)):
			return false;
		endif;
		
		foreach($this->sts as $key=>$value):
			$what = ($search_keys) ? $key : $value;
			if(strpos($what, $needle)!==false):
				 return $key;
			endif;
		endforeach;
		return false;	
	}

	//makes an array of the headers for each column
	private function tableHead(){
		$head = $this->sts[ ($this->secS) - ($this->secOff[$this->what]) ];
		$head = ltrim($head,"# ");
		$head = rtrim($head);
		$this->jsonObj['headers'] = explode(' - ', $head);
	}
	
	//adds each section of the stats file array into the $this->jsonObj[data] array
	private function jsonSection(){
		$i = $this->secS+1;
		while($i < $this->secE):
			$j = 0;
			$line = rtrim($this->sts[$i]);
			$ldata = explode(' ',$line);
			
			$j = count($ldata);
			$headCount = count($this->jsonObj['headers']);
			if($j < $headCount):	//if there are empty cells, make them null
				while($j < $headCount):
					$ldata[$j] = ' - ';
					$j++;
				endwhile;
			endif;
			$this->jsonObj['data'][] = $ldata;
			$i++;
		endwhile;
	}
	
	//only thing you have to call
	public function build(){
		$this->openFile();
		$this->secS = $this->arrayFind('BEGIN_'.$this->what);
		$this->secE = $this->arrayFind('END_'.$this->what);
		$this->tableHead();
		$this->jsonSection();
	}
}
?>