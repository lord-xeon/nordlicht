<?php 
class Y2D {
	public $month = '', $cache = '',$totals = array(), $oldMonth = '', $newMonth = '';
	const offset = 2;
	private	$keys = array('Date','Pages','Hits','Bandwidth','Visits');
	
	public function isToday(){
		if($this->month == date('mY')):
			return true;
		endif;
		return false;
	}
	
	//opens the y2d file
	public function getCache($file){
		if(is_file($file)):
			$cacheF = file($file);
			$this->cache = $cacheF;
		else:
			return 'invalid file';
		endif;
	}
	
	//totals up the monthly values
	public function getTotals($section){
		foreach($section as $h=>$id):
			foreach($id as $vl):
				$update[$h] += $vl;
			endforeach;
		endforeach;
		$this->totals = $update;
	}
	
	private function getMonth(){
		$m = $this->month;
		$cf = $this->cache;
		$cf2 = explode(' ',$cf[$m+self::offset]);
		$this->oldMonth = array_combine($this->keys, $cf2);
	}
		
	private function addUp(){
		$this->newMonth = $this->oldMonth;
		$i = 1;
		foreach($this->totals as $t=>$h):
			if($t != 'Date'):
				$this->newMonth[$t] = $h;
			endif;
		endforeach;
	}
	
	//
	public function builder(){
		$this->getMonth();
		$this->addUp();
	}
	
	//
	private function updateCache(){
		$m = $this->month;
		$this->cache[$m+self::offset] = implode(' ',$this->newMonth). "\n";
	}
	
	//write the new y2d file to disk
	public function writeCache($file){
		$this->updateCache();
		
		$f = fopen($file, 'w');
		foreach($this->cache as $l):
			$line .= $l;
		endforeach;
		fwrite($f,$line);
		fclose($f);
	}
}
?>