<?php
namespace udemzisoft\tomato;
class qeSearch implements queryElement
{
	public function __construct ($opt) {
		$this->standby ($opt,[
			'key'=>null,
				// 좌변
			'value'=>null,
				// 우변
			'operator'=>null
				// 연산자
					// none | = | < | <= | > | >= | != | like | %like | 
					// like% | in | reverse | period | is null | not null
		]);

		$this->start();
	}
	private function start() {
	}
	public function get() {
	}
}


