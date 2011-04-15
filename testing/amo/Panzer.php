<?php 
require_once('nordlicht.php');
require_once('../../funn/funnns.php');
class Panzer extends nordlicht {
	public	$tableMeta = array(),
			$checked = array(),
			$mv = array(),
			$mmv = array(),
			$limit = false,
			$sort = false,
			$wordSizes = 1,
			$offSet = 0;

	private $majorVersions = array(),
			$minorVersions = array();
			

	
	function __construct(){
		parent::__construct();
		
	}
	function __destruct(){
		$this->destroy();
	}
	
	public function builder(){
		parent::builder();
		$this->majorVersions = $this->sortTypes($this->mv);
	//	$this->minorVersions = $this->sortTypes($this->mmv);
	}
	
	public function debug(){
		echo '<pre>';
		//print_r($this->ss);
		echo '</pre>';
	}
	
	public function destroy(){
		parent::destroy();
		$this->hRows = $this->iRows = '';
		$this->tableMeta = $this->majorVersions = $this->minorVersions = array();
		$total = array();

	}
	
	public function sortTypes($which){
		$total = array();
		$tt = 0;

		foreach($which as $v):
			$total[$v] = 0;
			$i = 0;
			$bid = $this->ss['Browser ID'];
			while($i < count($bid)):
				$inV = strpos($bid[$i],$v);
				if($inV !== false){
					$total[$v] += $this->ss['Hits'][$i];
					$tt += $this->ss['Hits'][$i];
				}
				$i++;
			endwhile;
		endforeach;
		
		$total['Others'] = (array_sum($this->ss['Hits']) -$tt);

		return $total;
	}
	public function majorTable(){
		echo "<table class=\"nStats\">\n";
		echo "\t<tr>\n\t\t<th>Browser<th>\n\t\t<th>Hits</th>\n\t</tr>\n";
		foreach($this->majorVersions as $b=>$h):
			$td = "\t<tr>\n";
			$td .= "\t\t\<td>".$b."</td>\n";
			$td .= "\t\t<td>".$h."</td>\n";
			$td = "\t</tr>\n";
		endforeach;
		echo $td;
		echo "</table>\n";
	}
	
}
?>