<?php
use udemzisoft\tomato as ut;
require 'tomatoInclude/head.php';
ini_set('display_errors', 1);




$ARG = getpost::multi([
  "bId"=>"int",
  "mode"=>"text",
  "pageNumber"=>"int",
  "order1"=>"text",
  "sort1"=>"text",
  "order2"=>"text",
  "sort2"=>"text",
  "order3"=>"text",
  "sort3"=>"text",
  "Id"=>"int",
  "parent"=>"int",
  "returnUrl"=>"text",
  "method"=>"text",
  "showDeleted"=>"text",
  "page2"=>"int",
  "returnUrl"=>"text",
  "depth"=>"int",
  "loop"=>"int",
  "bIdC"=>"int",
  "_action"=>"text",
  "_bSkin"=>"text",
  "searchWord"=>"text",
  "noMessage"=>"text",
  "autoSave"=>"text"
]);
$ARG['authority'] = $AUTHORITY;
$ARG['mode']='list';//임시

$tomato = new ut\board($ARG,$DB);
$tomato->action();


require 'tomatoInclude/foot.php';