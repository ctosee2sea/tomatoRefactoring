<?php
namespace udemzisoft\tomato;
class qeTableField implements queryElement
{
	public function __construct ($opt) {
		$this->standby ($opt,[
			'table'=>null,
			'field'=>null
		]);

		$this->start();
	}
	private function start() {
	}
	public function get() {
		return 
			($this->table()?$this->table()->name():'')
			.($this->field()&&$this->table()?'.':'')
			.($this->field()?$this->field()->name():'');
	}
}