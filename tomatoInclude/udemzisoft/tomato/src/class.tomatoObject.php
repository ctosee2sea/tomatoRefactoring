<?php
namespace udemzisoft\tomato;
class tomatoObject implements itomatoObject
{
	// trait quickLoad
	use tquickLoad;


	/* * * * * * * * * * * * * * * * * * 
			en : managing property
			kr : 속성 변수 관리
	* * * * * * * * * * * * * * * * * */

		// en : property belong to $properties
		// kr : 속성 변수는 $properties
		private $properties=[];

		// en : make property on this
		// kr : 속성 변수 생성
		public function setProperty($name,$defaultValue=null) { 
			$this->properties[$name]=$defaultValue;
		}

		// en : make properties setter getter
		// kr : 속성 변수 입출력기 만들기
		public function standby($opt=[],$scheme=null) { 
			foreach (($scheme?$scheme:$opt) as $key => $value) {
				$this->setProperty($key
					,isset($opt[$key])?$opt[$key]:$value);
			};
		}


	/* * * * * * * * * * * * * * * * * * 
			en : managing readonly property
			kr : 읽기 전용 속성 변수 관리
	* * * * * * * * * * * * * * * * * */

		// en : readOnly property belong to $propertiesReadOnly
		// kr : 읽기 전용 속성 변수는 $propertiesReadOnly
		private $propertiesReadOnly=[];

		// en : make readonly property on this
		// kr : 읽기 전용 속성 변수 생성
		protected function setPropertyReadOnly($name,$defaultValue=null) { 
			$this->propertiesReadOnly[$name]=$defaultValue;
		}

		// en : make readonly properties getter
		// kr : 읽기 전용 변수 출력기 만들기
		protected function standbyReadonly($opt=[],$scheme=null) { 
			// getter만 생성, setter는 setProperty 사용하지만, protected 전용
			foreach (($scheme?$scheme:$opt) as $key => $value) {
				$this->setPropertyReadOnly($key
					,isset($opt[$key])?$opt[$key]:$value);
			};
		}


	/* * * * * * * * * * * * * * * * * * 
			en : property change event listener
			kr : 속성 변수 변화 이벤트 리스너
	* * * * * * * * * * * * * * * * * */

		// en : readOnly property belong to $propertiesReadOnly
		// kr : 읽기 전용 속성 변수는 $propertiesReadOnly
		private $propertiesListener=[];

		// en : make readonly property on this
		// kr : 읽기 전용 속성 변수 생성
		protected function setPropertyListener($propertyName,$function=null) { 
			$this->propertiesListener[$propertyName]=$function;
		}


	/* * * * * * * * * * * * * * * * * * 
			en : every scheme[] must be existed
			kr : scheme 안의 변수가 모두 존재하는지 확인
	* * * * * * * * * * * * * * * * * */

		protected function required ($scheme=[]) {
			foreach ($scheme as $key) {
				if (!isset($this->properties[$key])
					&&!isset($this->propertiesReadOnly[$key])) return false;
				if (isset($this->properties[$key])) {
					if ($this->properties[$key]===null) return false;
				} elseif (isset($this->propertiesReadOnly[$key])) {
					if ($this->propertiesReadOnly[$key]===null) return false;
				}
			};
			return true;
		}


	/* * * * * * * * * * * * * * * * * * 
			en : override magin method __call
			kr : 매직매소드 __call 재정의

		읽기 전용 속성 변수도 __call 에서 관리하는 이유는
		(즉, $this->member 가 아니라, $this->member() 로 접근하는 이유는)
		속성 변수가 읽기 전용인지 쓰기 겸용인지 여부는 변할 수 있기 때문임

	* * * * * * * * * * * * * * * * * */

		public function __call ($name,$arg) {
			foreach ($this->properties as $key => $value) {
				if ($name==$key) {
					if (sizeof($arg)) {
						$this->setProperty($key,$arg[0]);
						foreach ($this->propertiesListener as $p => $func) {
							if ($name==$p) $this->$func();
						}
					};
					return sizeof($arg)?$this:$this->properties[$key];
				};
			};
			foreach ($this->propertiesReadOnly as $key => $value) {
				if ($name==$key) {
					return $this->propertiesReadOnly[$key];
				};
			};
		}

}