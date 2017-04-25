<?php
namespace udemzisoft\tomato;
class system
{
	public function __construct () {
		
	}
	public function foo() {
		echo 'foo';
	}
	public function p ($msg) {
		if (is_array($msg)||is_object($msg)) {
			foreach ($msg as $key => $value) {
				echo '<div class="message"><b>'.$key.' : </b>';
				p ($value);
				echo '</div>';
			}
		} else {
			echo '<div class="message">'.$msg.'</div>';
		}
	}
	public function alert ($msga,$opt=null) {
		// opt는 아래처럼 사용할 수 있음
		if (!$opt) $opt = [
			"html5"=>false,
			"stop"=>false,
			"history"=>0,
			"url"=>null
		];

		if($opt['html5']) {
			?>
	   <!DOCTYPE html>
	   <html xml:lang="ko" lang="ko">
	      <head>
	         <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	         <title>Alert</title>
			<?
	}
		if ($opt['msga']) {
			?>
			<script type="text/javascript">
				alert("<?=$msga?>");
			</script>
			<?
		}

		if ($opt['history']) {
			?>
			<script type="text/javascript">
				history.go(<?=$opt['history']?>);
			</script>
			<?
		}


		if ($opt['url']) {
			?>
			<meta http-equiv="refresh" content="0; url=<?=$url?>">
			<?
		};

		if($opt['html5']) {
			?>
	      </head>
	      <body></body>
	   </html>
			<?
		}

		if ($opt['stop']) {
			exit();
		}
	}
	public function encrypt ($text) {
		return password_hash($text,PASSWORD_DEFAULT);
	}
}