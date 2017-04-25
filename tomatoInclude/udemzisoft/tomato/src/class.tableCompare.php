<?php
namespace udemzisoft\tomato;
class tableCompare extends tomatoObject
{
	public function __construct ($opt,$type=null) {
		$this->standby ($opt,[
			'left'=>null, // as tableField
			'right'=>null, // as tableField
			'relation'=>null
			// * =
			// * =<
			// * =>
			// * like
			// * 
		]);

	}
	public function getSql () {
		return ($this->table()?$this->table().'.':'').$this->field();
	}
}