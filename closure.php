<?
class to
{
	var $J=[];
	function standby($opt=[],$scheme=[]) {
		foreach ($scheme as $key => $value) {
			$this->J[$key] 
				= isset($opt[$key])?$opt[$key]:$value;
		};
	}
	function __call ($name,$arg) {
		foreach ($this->J as $key => $value) {
			if ($name==$key) {
				if (sizeof($arg)) {
					$this->J[$key]=$arg[0];
				};
				return sizeof($arg)?$this:$this->J[$key];
			};
		};
	}
};


class make  extends to
{
	function __construct ($opt) {
		$this->standby($opt,[
			'var1'=>'var1',
			'var2'=>'var2'
		]);
	}
}

$a= new make([
		'var1'=>'ok'
	]);
echo "1)";
echo $a->var1();
echo '<br>';

echo "2)";
echo $a->var1("var1")->var2("var2")->var1();
echo "<br>";

echo "3)";
echo $a->var1();
echo "<br>";

echo "4)";
echo $a->var2();











