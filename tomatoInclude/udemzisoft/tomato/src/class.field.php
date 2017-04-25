<?php
namespace udemzisoft\tomato;
class field extends tomatoObject
{

	/* * * * * * * * * * * * * * * * * * 
	en : how to make instance of field
	kr : 필드 인스턴스 생성 방법
	* * * * * * * * * * * * * * * * * */
	/*
		1. fieldId
		2. table instance && field identity
		3. field instance
	*/


	/* * * * * * * * * * * * * * * * * * 
	en : list of properties
	kr : 속성 목록
	* * * * * * * * * * * * * * * * * */

	/* * * * * * * * * * * * * * * * * * 

		DB ; object
			en : database connect instance
			kr : DB 접속 인스턴스
				//new \udemzisoft\tomato\db

		D ; object (from db)
			en : record data of this field
			kr : 이 field의 레코드 정보

		Id ; int 
			en : unique Id of field
			kr : 필드 고유 번호
				
		name ; string
			en : this field's name
			kr : 이 필드 이름

		identity ; string
			en : this field's identity
			kr : 이 필드 고유이름

		table ; object 
			en : table instance
			kr : 이 필드가 사용하는 테이블 인스턴스
				//new \udemzisoft\tomato\table



		#how diffrence name, identity, tableName
			name : 'member table for staff'
			identity : 'staffMember'
			tableName : 'etc_bs'.($systemStatus?'':'t').'_'.$identity


	* * * * * * * * * * * * * * * * * */


	public function __construct ($opt) {

		$this->standbyReadonly ($opt,[
			'table'=>null,
			'Id'=>null,
			'identity'=>null,
			'D'=>null,
			'DB'=>null
		]);
		if ($this->required ([
			'table',
			'Id',
			'identity',
			'D',
			'DB'
		])) return false;
		$this->start();
	}

	public function get ($Id,$table==null,$DB=null) { //static 전용 메소드
		switch (gettype($Id)) {
			// Id가 숫자일때
			case 'integer':
				//필드 데이터 불러오기
				$fieldD = ql('etc_bs_field','Id',$Id);

				//테이블이 없으면 새로 불러오기
				$table = $table?$table:new table([
					'Id'=>$fieldD->bs_tableId,
					'DB'=>$DB
				]);

				//이 필드의 소속 테이블이 잘못 되었으면 아웃
				if ($table->Id()!=$fieldD->bs_tableId) return false;
			break;

			//문자 일 때 // identity로 간주
			case 'string':
				//문자 일 때는 테이블 없으면 안됨
				if (!$table) return false;
				$fieldD = qs('etc_bs_field',[
						"identity"=>$Id,
						"bs_tableId"=>$table->Id()
					]);
			break;
		}
		$className = 'udemzisoft\\tomato\\field\\'.$fieldD->type;
		return new $className([
			'table'=>$table,
			'Id'=>$fieldD->Id,
			'identity'=>$fieldD->identity,
			'D'=>$fieldD,
			'DB'=>$DB
		],$board,$DB);
	}


	private function start () {
		
	}
}