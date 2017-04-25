<?php
use udemzisoft\tomato\boardSkin as utb;
namespace udemzisoft\tomato;
class boardSkin extends tomatoObject implements iboardSkin
{
	public function __construct ($opt,$board,$DB=null) {
		if (!$opt['Id']) return false;
		$this->setPropertyReadOnly('D',
			$this->ql('etc_bs_bskin','Id',$opt['Id']));

		$this->standbyReadonly([
			'Id'=>$this->D()->Id,
			'board'=>$board,
			'DB'=>$DB?$DB:$GLOBALS["DB"]
		]);

		$this->standby([
			'data'=>null,
			'result'=>null
		]);

		$this->required ([
			'Id',
			'DB'
		]);
		$this->ready();
	}
	public function get ($Id,$board,$DB=null) { //static 전용 메소드
		$skinD = ql('etc_bs_bskin','Id',$Id,0,0,$DB?$DB:$GLOBALS["DB"]);
		if (!$skinD) return false;
		$className = 'udemzisoft\\tomato\\boardSkin\\'.$skinD->folder;
		return new $className([
			'Id'=>$skinD->Id
		],$board,$DB);
	}


	public function ready () {
		// p ("denim_default load complete");
	}

	public function start ($mode) {
		$methodName = $mode.'Action';
		$this->$methodName();
	}
	public function listAction () {
		$result = null;

		$result .= $this->board()->pageNumber().'/'.$this->board()->pageCount();
		$result .= '<table border=1><thead><th></th>';
		foreach ($this->data()[0] as $key => $v) {
			$result .= '<th>'.$key.'</th>';
		}
		$result .= '</thead><tbody>';

		foreach ($this->data() as $number => $row) {
			$no = 
				$this->board()->count()
				- ($this->board()->pageMax() * ($this->board()->pageNumber()-1)
				+ $number);
			$result .= '<tr><td>'.$no.'</td>';
			foreach ($row as $value) {
				$result .= '<td>'.$value.'</td>';
			}
			$result .= '</tr>';
		}
		$result .= '</tbody></table>';
		$this->result($result);
	}
	public function insertAction () {

	}
	public function viewAction () {

	}
	public function modAction () {

	}
	public function ansAction () {
		
	}
	public function delAction () {

	}
	public function show () {
		echo $this->result();
	}
	public function boardSkin_error($msg) {
		echo '{"msg":"'.$msg.'"}';
	}

}