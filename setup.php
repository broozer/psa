<?php

/**
*¨[type] file
* [name] setup.php
* [package] psa
* [since] 2010.09.22
*/

include_once('./classes/Session.php');
include_once('./classes/LitePDO.php');
include_once('./classes/File.php');

if(!file_exists('data')) {
	mkdir('data');
}

$psa = new LitePDO('sqlite:./data/base.sqlite');
$q = "CREATE TABLE queries (id INTEGER PRIMARY KEY, qs TEXT , datum DATETIME(20), db VARCHAR(50), fine INTEGER(1))";

$psa->qo($q);

$q = "CREATE TABLE base (directory VARCHAR(128) , extension VARCHAR(20) , nr_rows INTEGER(7))";
$psa->qo($q);

$q = "INSERT INTO base (directory,extension, nr_rows) VALUES ('./data','sqlite',20)";
$psa->qo($q);

$q = "CREATE TABLE temp_table_fields (
		id INTEGER PRIMARY KEY
		,tblname VARCHAR(128) 
		,colname VARCHAR(128) 
		,coltype VARCHAR(48) 
		,colsize INT(10)
		,colprime INT(1)
		, colnull INT(1)
		, coldefault VARCHAR(128))";
$psa->qo($q);


unset($psa);

header('location: index.php?cmd=bts');
exit;
