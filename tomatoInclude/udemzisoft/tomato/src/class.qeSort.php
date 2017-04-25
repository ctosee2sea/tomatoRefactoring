<?php
namespace udemzisoft\tomato;
class qeSort implements queryElement
{
	public function __construct ($opt) {
		$this->standby ($opt,[
			'text'=>null,
			'tableField'=>null,
				//qeTableField
			'desc'=>null
				// [desc | asc]
		]);

		$this->start();
	}
	private function start() {
	}
	public function get() {
		return $this->tableField()->get().' '.$this->desc();
	}
}