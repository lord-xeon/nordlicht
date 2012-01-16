<?php 
require_once('Panzer.php');
class Panther extends Panzer {
	public	$tableMeta = array(),
			$checked = array(),
			$mv = array(),
			$mmv = array(),
			$limit = false,
			$sort = false;

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
	
	public function OSminor(){
		echo json_encode($this->OSlist(true));
	}	
	
	public function majorTable(){
		$td = '';
		echo "<table class=\"nStats\">\n";
		echo "\t<tr>\n\t\t<th>Operating System</th>\n\t\t<th>Hits</th>\n\t</tr>\n";
		$i = 1;
		foreach($this->majorVersions as $b=>$h):
			if($this->limit && $i > $this->limit){
				break;
			}
			$bn = strtoupper(substr($b,0,1)) . substr($b,1);
			switch($b):
				case 'Unknown':
					$b = 'unknown';
				break;
				case 'mobile':
					$b = 'linuxandroid';
					break;
				case 'cp/m':
					$b = 'cpm';
					break;
			endswitch;
			
			$bc = $this->checked[$b]['color'];
			$td .= "\t<tr>\n";
			$td .= "\t\t".'<td data-piecolor="'.$bc.'" data-piename="'.$b.'" data-pieval="'.$h.'">'."\n";
			$td .= "\t\t\t".'<img src="images/os/'.$b.'.png" alt="'.$b.'"/>'.$bn."</td>\n";
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