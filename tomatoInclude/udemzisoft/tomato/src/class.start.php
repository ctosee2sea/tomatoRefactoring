<?php
namespace udemzisoft;
class start extends tomatoObject
{
	private $optScheme = [];
	private $getScheme = [
		 'bId'
		,'mode'
		,'page'
		,'order'
		,'sort'
		,'order2'
		,'sort2'
		,'order3'
		,'sort3'
		,'id'
		,'parent'
		,'searchKey'
		,'searchRelation'
		,'key'
		,'word'
		,'returnUrl'
		,'method'
		,'showDeleted'
		,'page2'
		,'historyId'
		,'returnUrl'
		,'depth'
		,'parent'
		,'loop'
		,'bIdC'
		,'_action'
		,'_bSkin'
		,'searchWord'
		,'noMessage'
		,'autoSave'
	];
	public $tomatoStart;
	public function __construct () 
	{
		$filters = array();
		foreach ($this->getScheme => $keyname) 
		{
			$filters[$keyname] = array("filter"=>FILTER_SANITIZE_STRING);
		}
		$opt = filter_input_array(INPUT_GET, $filters);
		$tomatoStart = new tomato($opt['bId'],$opt);
	}
}