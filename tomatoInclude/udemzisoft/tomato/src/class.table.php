<?php
namespace udemzisoft\tomato;
class table extends tomatoObject
{

	/* * * * * * * * * * * * * * * * * * 
	en : how to make instance of table
	kr : 테이블 인스턴스 생성 방법
	* * * * * * * * * * * * * * * * * */
	/*
		1. table Id
		* identity로는 생성할 수 없음 !!! (중복 가능성)
	*/

	/* * * * * * * * * * * * * * * * * * 
	en : list of properties
	kr : 속성 목록
	* * * * * * * * * * * * * * * * * */

	/* * * * * * * * * * * * * * * * * * 

		Id ; int 
			en : unique Id of table
			kr : 테이블 고유 번호
				
		DB ; object
			en : database connect instance
			kr : DB 접속 인스턴스
				//new \udemzisoft\tomato\db

		D ; object (from db)
			en : record data of this table
			kr : 이 table의 레코드 정보

		name ; string
			en : this table's name
			kr : 이 테이블 이름

		identity ; string
			en : this table's identity
			kr : 이 테이블 고유이름

		tableName ; string
			en : this table's full name
			kr : 이 테이블 풀네임

		#how diffrence name, identity, tableName
			name : 'member table for staff'
			identity : 'staffMember'
			tableName : 'etc_bs'.($systemStatus?'':'t').'_'.$identity

	* * * * * * * * * * * * * * * * * */


	public function __construct ($opt,$DB=null) {
		if (!$opt['Id']) return false;
		$this->setPropertyReadOnly('DB',$DB?$DB:$GLOBALS["DB"]);
		$this->setPropertyReadOnly(
			'D',
			$this->ql('etc_bs_table','Id',$opt['Id']));

		$this->standbyReadonly ([
			'Id'=>$this->D()->Id,
			'name'=>$this->D()->name,
			'identity'=>$this->D()->identity,
			'tableName'=>'etc_bs'.($this->D()->system?'':'t').'_'
				.$this->D()->identity
		]);

		if (!$this->required(['DB','Id'])) return false;

		$this->start();
	}


	/* * * * * * * * * * * * * * * * * * 
	en : get field from this table
	kr : 이 테이블의 필드 중 하나 가져오기
	* * * * * * * * * * * * * * * * * */

	public function getField ($Id) {
		if (!$Id) return false;		
		return field::get($Id,$this->table(),$this->DB());
	}
}