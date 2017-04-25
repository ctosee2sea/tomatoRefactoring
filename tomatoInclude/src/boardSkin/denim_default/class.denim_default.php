<?php
namespace udemzisoft\tomato\boardSkin;
class denim_default extends \udemzisoft\tomato\boardSkin
{
	// __construct는 boardSkin 것을 사용함
	public function ready() {
		// p ("denim_default load complete");
	}

	public function start ($mode) {
		parent::start($mode);
	}

	// 아래의 메소드를 삭제하면 기본 메소드를 사용함
	public function listAction () {
		parent::listAction();
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
	public function boardSkin_error($msg) {
		goBack('권한이 없습니다');
	}
}
