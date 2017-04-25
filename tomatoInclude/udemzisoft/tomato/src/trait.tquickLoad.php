<?php
namespace udemzisoft\tomato;
trait tquickLoad
{
	//테이블, 컬럼, 값으로 DB에서 간단히 검색해 오는 클래스
	private $buffer=[];

	/* * * * * * * * * * * * * * * * * * 
			en : quick load record with single condition
			kr : 1개의 검색 조건으로 record 불러오기
	* * * * * * * * * * * * * * * * * */

	// en : 
	//
	public function ql ($table,$column,$var,$deleted=0,$new=0,$DB=null) {
		$this->quickLoadCheckQuickLoad();

		$this->buffer = $GLOBALS['QUICKLOAD_CACHE'];

		//keyname을 기준으로 buffer에 저장해 놓고, 같은 조건이 요청 되었을 때는 buffer 반환
		//new가 있을 때는, buffer 상관 없이 새로 불러옴
		$keyname = $table."_".$column."_".$var."_".$deleted;

		if (!$this->buffer->get($keyname)||$new) {
			$P = $this->quickLoadExecute($table,$column,$var,$deleted,$DB);
			$D = $P->fetchObject();
			$this->buffer->set($keyname,$D);
			$this->quickLoadResult($D);
		}
		return $this->buffer->get($keyname);
	}
	public function qls ($table,$column,$var,$deleted=0,$new=0,$DB=null) {
		$this->quickLoadCheckQuickLoad();

		$this->buffer = $GLOBALS['QUICKLOAD_CACHE'];

		$keyname = $table."_s_".$column."_".$var."_".$deleted;
		if (!$this->buffer->get($keyname)||$new) {
			$P = $this->quickLoadExecute($table,$column,$var,$deleted,$DB);
			$rtn = null;
			$D = $P->fetchAll(\PDO::FETCH_OBJ);
			$this->buffer->set($keyname,$D);
			$this->quickLoadResult($D);
		}
		return $this->buffer->get($keyname);
	}

	private function quickLoadExecute ($table,$column,$var,$deleted=0,$DB=null) {
		$query = 'select * from '.$table.' where '.$column.'=:var';
		if (!$deleted) {
			$query .= ' and `deleted`="0" ';
		} elseif($deleted==1) {
			$query .= ' and `deleted`="1" ';
		} else {
			$query .= ' and `deleted`=:deleted ';
		}

		$this->quickLoad_query($query);

		if ($DB) $P = $DB->prepare($query);
		else $P = $this->DB()->prepare($query);
		
		$P->bindValue('var',$var);

		if ($deleted&&$deleted!=1) $P->bindValue('deleted',$deleted);
		$P->execute();
		return $P;
	}


	/* * * * * * * * * * * * * * * * * * 
			en : quick load record with multiple condition
			kr : 복수개의 검색 조건으로 record 불러오기
	* * * * * * * * * * * * * * * * * */

	public function qs ($table,$search,$deleted=0,$DB=null) {
		$this->quickLoadCheckQuickLoad();

		$query = 'select * from '.$table.' where ';
		$n = 0;
		foreach ($search as $key => $value) $query.=($n>0?' and ':' ').$key.'=:var'.$n++;
		if (!$deleted) {
			$query .= ' and `deleted`="0" ';
		} elseif($deleted==1) {
			$query .= ' and `deleted`="1" ';
		} else {
			$query .= ' and `deleted`=:deleted ';
		}
		
		$this->quickLoad_query($query);

		if ($DB) $P = $DB->prepare($query);
		else $P = $this->DB()->prepare($query);

		$n = 0;
		foreach ($search as $key => $value) $P->bindValue('var'.$n++,$value);

		if ($deleted&&$deleted!=1) $P->bindValue('deleted',$deleted);
		$P->execute();
		$D = $P->fetchAll(\PDO::FETCH_OBJ);
		return $D;
	}

	//quickload 처음 사용 초기화
	private function quickLoadCheckQuickLoad () {
		if (!$this->quickLoad_query()) {
			$this->standby([
				'quickLoad_query'=>null,
				'DB'=>$this->DB()?$this->DB():$GLOBALS["DB"],
				'quickLoadResult'=>null
			]);
		}
	}
}




