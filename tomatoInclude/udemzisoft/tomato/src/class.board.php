<?php
namespace udemzisoft\tomato;
class board extends tomato implements iboard
{

	/* * * * * * * * * * * * * * * * * * 
	en : list of readonly properties
	kr : 읽기 전용 속성 목록
		* bSkin 에서는 수정하지 않을 것을 권장하는 속성이다.
	* * * * * * * * * * * * * * * * * */

	/* * * * * * * * * * * * * * * * * * 

		en : board basis Information
		kr : 보드 기초 정보

			DB ; object
				en : database connect instance
				kr : DB 접속 인스턴스
					//new \udemzisoft\tomato\db

			D ; object (from db)
				en : record data of this board
				kr : 이 보드의 레코드 정보

			table ; object 
				en : table instance
				kr : 이 보드가 사용하는 테이블 인스턴스
					//new \udemzisoft\tomato\table

			tableName ; string
				en : this table's full name
				kr : 이 테이블 풀네임

			authority ; object
				en : instance of authority
				kr : 권한 정보 인스턴스
					//new \udemzisoft\tomato\authority

			bId ; int
				en : Id number of board 
				kr : 보드의 고유 Id

			bIdentity ; string
				en : identity name of board
				kr : 보드의 고유명

			insert_set_opened ; boolean
				en : did 'insert_head.php' file loaded
					when it use insert multi, deny double loading of head,foot
				kr :  insert_head.php가 로딩 되었는지 여부
					insert multi 사용 시, head와 foot를 중복 로딩하지 않도록 함

			loop ; int
				en : when it use multiple mode, check count of this call
					in order to generate field unique name
				kr : multiple인 경우 필드의 고유값을 위해 몇 번째 반복인지 체크

			loaded ; boolean
				en : is this board loaded more than once
				kr :  이 보드가 한 번이상 로딩 되었는지 확인 

			useTrash ; boolean
				en : is this board has trash
				kr : 휴지통 사용 여부


		en : multiple mode (list,inline,realtime) option
		kr : 복수 검색용 옵션

			selectLeftJoin ; array
				en : injection field or string into sql select
				kr : select단에 집어 넣을 필드 혹은 string 등

			leftJoin ; object
				en : left join 
				kr : left join 정보
				// new \udemzisoft\tomato\qeJoin

			rightJoin ; object
				en : right join
				kr : right join 정보
				// new \udemzisoft\tomato\qeJoin

			deletedJoinOuter ; boolean
				en : 'deleted=0' with 'join' or 'where'
				kr : deleted 검색을 where로 뺄 것인지 여부
				// 	* true > where [tableName].deleted=0
				// 	* false > left join [tableName] on [tableName].deleted=0

			loadSearchIndex_loaded ; boolean
				en : check 'loadSearchIndex' already run
				kr : loadSearchIndex 가 실행되었는지 확인


		en : single mode (view,insert,mod...)
		kr : 단수 검색용 옵션

			parent ; int
				en : parent's unique Id (reply)
				kr : 이 레코드의 상위 레코드의 고유 Id (답변을 달때 사용)

			readD ; object (from db)
				en : data source of single record (result of sql)
				kr : record를 1개 불러올 경우 (view,mod) 데이터 소스

			oId ; int
				en : original unique id of record
				kr : 레코드의 original 고유 Id
				
				originalId와 다른 점은 oId는 내부에서 복사나 수정시 사용하는 상태 변수이고,
				originalId는 외부에서 검색을 위해 입력받는 값이다.
				같은 필드를 지칭한다.

			showMakeFormDefault ; boolean
				en : check form elements already loaded
				kr : insert에서 사용할 기본 form 요소들을 불러 왔는지 여부

			depth ; int
				en : depth status of this record
				kr : 이 데이터의 depth 정보


		en : save mode
		kr : save 관련 옵션

			actionLoadCount ; int
				en : count of running action
				kr : action 메소드가 실행된 횟수


		en : subTomato
		kr : subTomato 일때 옵션

			field ; int
				en : (if this is subtomato) unique id of 
					foreign key to parent tomato
				kr : subtomato 일 때 parent tomato 와 연결된 필드 고유 Id [fkey]

			multi ; array
				en : subtomato information
				kr : subtomato 정보

				mode ; string ; [list|insert|view|mod|ans|del|realtime|inline]
					en : when current board's mode is this load subtomato
					kr : 현재 보드의 mode가 이것일 때 subtomato 불러옴

				targetBoard ; object
					en : subtomato instance
					kr : subtomato 인스턴스
					//new \udemzisoft\tomato\board

				targetMode ; string ; [list|insert|view|mod|ans|del|realtime|inline]
					en : subtomato's mode
					kr : subtomato의 모드

				targetField ; object
					en : foreign key instance
					kr : 연결 필드 인스턴스
					//new \udemzisoft\tomato\qeField

			subTomato ; boolean
				en : subTomato exist
				kr : subTomato 있는지 여부

			subTomatoA ; array
				en : getFieldOrder or subTomato saving
				kr : save 할 서브 토마토의 getFieldOrder값

			parentBoard ; object
				en : parentBoard instance, when it is subtomato
				kr : multiBoard인경우 상위 board 인스턴스

		//플러그인 
			pluginA ; array
				en : plugin list
				kr : 불러올 플러그인 목록
				// new \udemzisoft\tomato\plugin
		]);
	* * * * * * * * * * * * * * * * * */


	/* * * * * * * * * * * * * * * * * * 
	en : list of properties
	kr : 속성 목록
	* * * * * * * * * * * * * * * * * */

	/* * * * * * * * * * * * * * * * * * 

		en : board basis Information
		kr : 보드 기초 정보

			mode ; string ; [list|insert|view|mod|ans|del|realtime|inline]
				en : current mode
				kr : 현재 입력된 모드
					
			loginId ; int
				en : current memeber id in by session
				kr : 현재 member 세션의 고유번호

			api ; boolean
				en : is this api mode
				kr : bolean 현재 api모드인지 확인

			skin ; object
				en : board skin instance
				kr : 보드 스킨 인스턴스


		en : single mode (view,insert,mod...)
		kr : 단수 검색용 옵션

			Id ; int 
				en : unique Id of record
				kr : 레코드 고유 번호

		en : mutiple mode (list,inline,realtime) information
		kr : 복수 검색용 옵션

			page ; int
				en : page number
				kr : 페이지 번호

			pageC ; int
				en : page count
				kr : 페이지 개수

			count ; int
				en : record count
				kr : 레코드 총 개수

			order1 ; string
			order2 ; string
			order3 ; string
			sort1 ; string ; [asc|desc]
			sort2 ; string ; [asc|desc]
			sort3 ; string ; [asc|desc]
				en : order by what
				kr : 정렬 기준

			sort ; object 
				en : how to sorting
				kr : 정렬 방법
				//new \udemzisoft\tomato\qeSort

			limit ; int
				en : limit of load record at once
				kr : 한페이지에 불러올 레코드 개수

			pageMax ; int
				en : count of page at pagination
				kr : pagination에서 한번에 불러올 페이지 개수

			showDeleted ; string [0|1|m]
				en : search deleted status
				kr : deleted 필드 검색 값


			trashAc == false : showDeleted != 1
			historyAc == false : showDeleted != m
				
				Id,deleted,oId
				(1 , 0 , 0)
				(2 , m , 1)
				(3 , m , 1)
				(4 , 1 , 0)
				(5 , 1 , 0)
				(6 , 0 , 0)

			list
				(showDeleted == 1)
					-> trashAc 확인 후 4,5 반환 
				(showDeleted == 0)
					-> 1,6 반환 
				(showDeleted == m)
					-> false
				(showDeleted == m && Id == 1)
					-> historyAc 확인 후 1,2,3 반환

			view
				(showDeleted == 1 && Id == 1)
					-> false
				(showDeleted == 1 && Id == 2)
					-> false
				(showDeleted == 1 && Id == 4)
					-> trashAc 확인 후 4 반환
				(showDeleted == m && Id == 2)
					-> historyAc 확인 후 2 반환


			groupby ; object
				en : group by instance
				kr : group by 인스턴스
				//new \udemzisoft\tomato\qeGroupby

			manualJoinA ;  object
				en : manual join instance
				kr : 수동 조인 인스턴스
				// new \udemzisoft\tomato\qeJoin

			orderHardCoding ; string
				en : hard coding for sort (hard coding have priority then other)
				kr : 정렬 하드 코딩 (하드 코딩이 sort보다 우선함)

			search ;  object
				kr : search instance
				kr : search 인스턴스
				//new \udemzisoft\tomato\qeSearch


		en : unEnable Option
		kr : 비활성화 옵션 

			noAutoSearch=> ;  boolean
				en : when TRUE autoSearch unEnable
				kr : true일 때는 autoSearch 비활성화

			noGroupBy ;  boolean
				en : when TRUE group by unEnable
				kr : true일 때는 group by 비활성화

			noMessage ;  boolean
				en : when TRUE json으로 이루어진 결과문 unEnable
				kr : true일 때는 json으로 이루어진 결과문 비활성화

			noMulti ;  boolean
				en : when TRUE multiBoard unEnable
				kr : true일 때는 multiBoard 비활성화

			noReturn ; boolean
				en : when TRUE action 비활성화, sql문만 표시하고 unEnable
				kr : true 일때는 action 비활성화, sql문만 표시하고 끝냄

			noSkin ; boolean
				en : when TRUE 스킨 unEnable
				kr : true 일때는 스킨 비활성화

			noTrigger ; boolean
				en : when TRUE trigger unEnable
				kr : true 일 때는 trigger 비활성화
	
		en : save option
		kr : save 관련

			returnUrl ; string
				en : return url after saving
				kr : save 실행 후 돌아갈 Url



	* * * * * * * * * * * * * * * * * */


	public function __construct ($opt,$DB=null) {

		// bId가 없으면 중단
		if (!$opt['bId']) return false;

		//DB 객체 선언
		$this->setPrivate('DB',$DB ? $DB : $GLOBALS["DB"]);
		// if (!$this->required(['DB'])) return false;
		//이 보드 정보 불러오기. bId 값이 숫자면, Id로,문자면 Identity 필드로 매칭
		$this->setPropertyReadOnly('D',
			$this->ql('etc_bs_board'
				,(is_numeric($opt['bId']) ? 'Id' : "identity")
				,$opt['bId']));
		if (!$this->required(['D'])) return false;

		//이 보드의 테이블 정보 불러오기
		$this->setPropertyReadOnly('table',
			new table([
				'Id'=>$this->D()->bs_tableId,
				'DB'=>$this->DB()
			])
		);
		if (!$this->required(['table'])) return false;

		/*
		# 자동 생성 값 getter만 사용 가능
		** standbyReadonly 로 선언한 값들은 
			protected setPropertyReadOnly(name,value) 로 set 가능 **
		*/
		$this->standbyReadonly([
			'authority'
				=>$opt['authority'] ? $opt['authority'] : $GLOBALS['AUTHORITY'],
			'bId'=>$this->D()->Id,
			'bIdentity'=>$this->D()->identity,
			'insert_set_opened'=>false,
			'loop'=>0,
			'loaded'=>false,
			'useTrash'=>$this->table()->D()->useTrash,
			'tableName'=>$this->table()->tableName(),
			'selectLeftJoin'=>null,
			'leftJoin'=>null,
			'rightJoin'=>null,
			'deletedJoinOuter'=>false,
			'loadSearchIndex_loaded'=>false,
			'parent'=>null,
			'readD'=>null,
			'oId'=>null,
			'showMakeFormDefault'=>false,
			'depth'=>null,
			'actionLoadCount'=>0,
			'field'=>null,
			'multi'=>null,
			'subTomato'=>false,
			'subTomatoA'=>null,
			'parentBoard'=>null,
			'pluginA'=>null
		]);

		// opt 기반으로 getter,setter 만드는 값
		$this->standby ($opt,[ // getter, setter 만들기
			'Id'=>null,
			'mode'=>$this->D()->mode,
			'loginId'=>0,
			'api'=>false,
			'pageNumber'=>1,
			'pageCount'=>0,
			'count'=>0,
			'order1'=>null,
			'order2'=>null,
			'order3'=>null,
			'sort1'=>null,
			'sort2'=>null,
			'sort3'=>null,
			'sort'=>null,
			'limit'=>$this->D()->pageMax,
			'pageMax'=>$this->D()->pageMax2,
			'showDeleted'=>0,
			'noAutoSearch'=>false,
			'noGroupBy'=>false,
			'noMessage'=>true,
			'noMulti'=>false,
			'noReturn'=>false,
			'noSkin'=>true,
			'noTrigger'=>false,
		]);

		//property change listener
		$this->setPropertyListener("showDeleted","renderDeleted");

		// opt 기반으로 getter,setter 만드는 값
		$this->standby ($opt,[
			'showDeleted'=>0,
		]);

		/*
		# 기본으로 입력받지는 않지만, getter, setter로 만들기
		*/
		$this->standby ([
			'skin'=>boardSkin::get($this->D()->skinId,$this,$this->DB()),
			'groupby'=>null,
			'manualJoinA'=>null,
			'orderHardCoding'=>null,
			'search'=>null,
			'returnUrl'=>null,
		]);

		//필수 변수
		if (!$this->required(['bId','mode'])) return false;
		// 권한 확인
		if (!$this->checkAuthority()) return false;
	}


	/* * * * * * * * * * * * * * * * * * 
			en : organize showDeleted property
			kr : showDeleted 정리
	* * * * * * * * * * * * * * * * * */

	private function renderDeleted () {
		switch ($this->showDeleted()) {
			case '1':
				if ($this->checkAuthority("trash")) 
					$this->setSearch('deleted',1,"system","=");
				else $this->showDeleted(0);
				break;
			case 'm':
				if ($this->checkAuthority("history")
					&& $this->Id()
					&& in_array($this->mode,array('list','view'))
				) {
					switch ($this->mode()) {
						case 'list':
							$this->setHardSearch(
								'('.$this->tableName().'.Id='.$this->Id()
									.' or '
								.$this->tableName().'.oId='.$this->Id().')'
							);
							break;
						case 'view':
							$this->setSearch('deleted','m',"system","=");
							break;
					}
				}
				else {
					$this->showDeleted(0);
				}
				break;
		}
		if ($this->showDeleted()==0) $this->setSearch('deleted',0,"system","=");
	}

	/* * * * * * * * * * * * * * * * * * 
			en : check authority
			kr : 권한 확인
	* * * * * * * * * * * * * * * * * */

	private function checkAuthority ($mode=null) {
		//현재 모드의 접근 가능 값이 etc_bs_board 에 저장되어 있고, this->D 에 로딩되어 있음
		//listAc, listAcMember 필드 참조
		$mode = $mode ? $mode : $this->mode();
		$ac = $mode.'Ac';
		$acMember = $mode.'AcMember';

		if (
			!$this->authority()
				->checkMembership(explode(",", $this->D()->$ac))
			//이 게시판 권한 그룹 소속인가?
			&&
			!$this->authority()
				->checkMembership(explode(',', $this->D()->adminAc))
			//이 게시판 관리자 그룹 소속인가?
			&&
			!$this->authority()->checkMember($this->D()->$acMember)
			//이 게시판 개인 권한자 인가?
			&&
			!$this->authority()->checkMember($this->D()->adminAcMember)
			//이 게시판 개인 관리자 인가?
			) {
			//모두 아니면 권한 없음으로 간주
			return false;
		}
		return true;
	}

	public function action() {
		// subTomato 있는지 확인
		// $this->loadSubTomato();

		// 기본 검색 준비
		// $this->loadSearchIndex();

		// 자동 검색 준비
		// if (!$this->noAutoSearch) $this->loadAutoSearch();

		// if (in($this->mode,"insert,copy,ans")) $readD = $this->resetId();


		// $this->actionLoaded=true;

		// if ($this->noSkin)
		// 	return $this->action2(null);
		// else {
		// 	if (is_file($this->bSkinPath."index.php")) include($this->bSkinPath."index.php");
		// 	else p ($this->bSkinPath."index.php 파일이 존재하지 않습니다.");
		// }

		//지금 레코드 불러오기
		$this->setPropertyReadOnly("readD",$this->load());

		$this->skin()->data($this->readD());
		$this->skin()->start($this->mode());
		$this->skin()->show();
	}

	/* * * * * * * * * * * * * * * * * * 
			en : loading record
			kr : 레코드 불러오기
	* * * * * * * * * * * * * * * * * */

	public function load ($mode=null) {
		$mode = $mode ? $mode : $this->mode();

		//single mode에서
		if (in_array($mode,array('del','mod','view','insert','copy','ans'))) {

			//Id 값이 없으면 안됨
			if (!$this->Id()) return false;
			
			//이미 로딩된 record를 불렀을 때는 다시 불러오지 않음
			if ($this->readD() && $this->readD()->Id==$this->Id())
				return $this->readD();
		}

		//값 불러오기
		switch ($mode?$mode:$this->mode()) {
			case 'realtime':
			case 'inline':
			case 'list':
				$sql = '
					SELECT * 
						FROM '.$this->tableName();
				$countSql = '
					SELECT count(*) as cc 
						FROM '.$this->tableName();
				$countP = $this->DB()->prepare($countSql);
				$countP->execute();
				$count = $countP->fetchObject();
				// print_r($count);

				$this->count($count->cc);
				$this->pageCount(ceil($this->count()/$this->pageMax()));
				$this->pageNumber(
					!$this->pageNumber() || $this->pageNumber()>$this->count() 
					? 1 
					: ($this->pageNumber()>$this->pageCount()
						? $this->pageCount()
						: $this->pageNumber()
					)
				);

				//limit 개수 설정
				$sql .=
					' LIMIT '
					.($this->pageMax() * ($this->pageNumber()-1)<0
						? 0
						: $this->pageMax() * ($this->pageNumber()-1))
					.', '.($this->pageMax()*1);

				$prepare = $this->DB()->prepare($sql);
				$prepare->execute();
				return $prepare->fetchAll(\PDO::FETCH_OBJ);
				break;
			case 'del':
			case 'mod':
			case 'view':
				return $this->ql($this->tableName()
					,(is_numeric($this->Id()) ? 'Id' : "identity")
					,$this->Id()
					,$this->showDeleted()
				);
				break;
			case 'insert':
				return $this->ql($this->tableName()
					,(is_numeric($this->Id()) ? 'Id' : "identity")
					,$this->Id()
					,'t'
				);
				break;
			case 'copy':
				$this->setPropertyReadOnly("oId",$this->Id());
				return $this->ql($this->tableName()
					,(is_numeric($this->Id()) ? 'Id' : "identity")
					,$this->Id()
					,$this->showDeleted()
				);
				break;
			case 'ans':
				return $this->ql($this->tableName()
					,(is_numeric($this->Id()) ? 'Id' : "identity")
					,$this->parent()
				);
				break;
			default:
				return false;
				break;
		}
	}

	public function save() {
		
	}
	public function getFieldOrder() {
		
	}
	public function setSearch($key="",$value=0,$from="system",$operator=null) {
		
	}
}