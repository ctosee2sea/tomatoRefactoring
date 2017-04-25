<?php
namespace udemzisoft;
interface fieldType
{
	public function makeForm();
	public function getListIndex();
	public function makeListIndex();
	public function makeIndexKey();
	public function checkIndex();
	public function dataParsing();
	public function save();


}