<?php
namespace udemzisoft\tomato;
interface itomatoObject
{
	public function standby();
	public function __call($name,$arg);
}