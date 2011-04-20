<?php 
require_once('nordlicht.php');
require_once('../funn/funnns.php');
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
	}
	
	public function Browserbuilder(){
		$this->builder();
		$this->majorVersions = $this->sortTypes($this->mv);
	}
	
	
	public function OSbuilder(){
		$this->builder();
		arsort($this->ss['OS ID']);
		$this->majorVersions = $this->OSlist();
	}
	

	public function destroy(){
		parent::destroy();
		$this->tableMeta = $this->majorVersions = $this->minorVersions = array();
		$total = array();
	}
	
	
	public function minorHold(){
		echo json_encode($this->sortTypes($this->mmv));
	}
	
	public function OSminor(){
		echo json_encode($this->OSlist(true));
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
		$td = '';
		echo "<table class=\"nStats\">\n";
		echo "\t<tr>\n\t\t<th>Browser</th>\n\t\t<th>Hits</th>\n\t</tr>\n";
		
		foreach($this->majorVersions as $b=>$h):
			$bn = '';
			switch ($b):
				case 'msie':
					$bn = 'Internet Explorer';
					break;
				default:
					$bn = strtoupper(substr($b,0,1)) . substr($b,1);
			endswitch;
			$bc = $this->checked[$b]['color'];
			$td .= "\t<tr>\n";
			$td .= "\t\t".'<td data-piecolor="'.$bc.'" data-piename="'.$b.'" data-pieval="'.$h.'">'."\n";
			$td .= "\t\t\t".'<img src="images/browsers/'.$b.'.png" alt="'.$b.'"/>'.$bn."</td>\n";
			$td .= "\t\t<td>".number_format($h)."</td>\n";
			$td .= "\t</tr>\n";
		endforeach;
		echo $td;
		echo "</table>\n";
	}
	
	public function OStable(){
		$td = '';
		$i = 1;
		echo "<table class=\"nStats\">\n";
		echo "\t<tr>\n\t\t<th>Operating System</th>\n\t\t<th>Hits</th>\n\t</tr>\n";
		foreach($this->majorVersions as $b=>$h):
			if($i > $this->limit):
				break;
			endif;
			
			$bn = strtoupper(substr($b,0,1)) . substr($b,1);
			$bc = $this->checked[$b]['color'];
			
			$td .= "\t<tr>\n";
			$td .= "\t\t".'<td data-piecolor="'.$bc.'" data-piename="'.$b.'" data-pieval="'.$h.'">'.$bn."</td>\n";
			$td .= "\t\t<td>".number_format($h)."</td>\n";
			$td .= "\t</tr>\n";
			$i++;
		endforeach;
		echo $td;
		echo "</table>\n";
	}
	
	
	public function OSlist($skip=false){
		$total = array();
		foreach($this->ss['Hits'] as $id=>$h):
			$osid = $this->ss['OS ID'][$id];
			if($skip):
				$total[$osid] = $h;
			else:
				$known = false;
				foreach($this->mv as $os):
					$inV = strpos($osid,$os);
					if($inV !== false):
						$total[$os] += $h;
						$known = true;
					endif;
				endforeach;
				if($known == false):
					switch($osid):
						case 'blackberry':
							$total['mobile'] += $h;
							break;
						case 'symbian':
							$total['mobile'] += $h;
							break;
						default:
							$total[$osid] = $h;
					endswitch;
				endif;
			endif;
		endforeach;
		arsort($total);
		
		return $total;
	}
	
}
?>