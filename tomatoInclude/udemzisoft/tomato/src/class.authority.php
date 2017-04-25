<?php
namespace udemzisoft\tomato;
class authority extends tomatoObject 
{
	/* * * * * * * * * * * * * * * * * * 
	en : list of properties
	kr : 속성 목록
	* * * * * * * * * * * * * * * * * */

	/* * * * * * * * * * * * * * * * * * 

		Id ; int 
			en : unique Id of member
			kr : 멤버 고유 번호
				
		DB ; object
			en : database connect instance
			kr : DB 접속 인스턴스
				//new \udemzisoft\tomato\db

		identity ; string
			en : this member's identity
			kr : 이 멤버 고유 아이디

		password ; string
			en : this member's password
			kr : 이 멤버 비밀번호

		name ; string
			en : this member's name
			kr : 이 회원 이름

		token ; string
			en : this token
			kr : 토큰명

		membership ; array
			en : membership member belong to 
			kr : 이 회원이 소속된 멤버쉽 종류

	* * * * * * * * * * * * * * * * * */

	public function __construct ($opt,$DB=null) {

		$this->standbyReadonly($opt,[
			'DB'=>$DB?$DB:$GLOBALS["DB"],
			'membership'=>[],
			'Id'=>null,
			'identity'=>null,
			'password'=>null,
			'name'=>null,
			'token'=>null
		]);

		if ($this->Id()!=null&&$this->Id()) {
			$D = $this->ql('etc_bs_member','Id',$this->Id());
		} elseif ($this->identity()!=null&&$this->identity()
			&&$this->password()!=null&&$this->password()) {
			$D = $this->qs('etc_bs_member',[
				'identity'=>$this->identity(),
				'password'=>system::encrypt($this->password)
			]);
		} elseif ($this->token()!=null&&$this->token()) {

		}
		$this->name($D->name);
		$this->identity($D->identity);

		//membership

		$this->setPropertyReadOnly('membership',
			array_map(function ($v) {return $v->membershipId;},
				$this->qls('etc_bs_member_memberShip','memberId',$this->Id()))
		);

		// $this->start();
	}
	public function start () {

	}
	public function checkMembership ($authA=null) {
		if (!$authA||!$this->membership()) return false;
		foreach ($authA as $a) 
			if (in_array($a,$this->membership())) return true;
		return false;
	}
	public function checkMember ($authId) {
		return (
			$this->Id()==$authId
			&&$this->Id()
			&&$authId);
	}
	public function login () {

	}
	public function logout () {

	}
}