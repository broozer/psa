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
$q = "CREATE TABLE queries (id INTEGER PRIMARY KEY, qs TEXT , datum DATETIME(20), db VARCHAR(50))";

$psa->qo($q);

$q = "CREATE TABLE base (directory VARCHAR(128) , extension VARCHAR(20))";
$psa->qo($q);

$q = "INSERT INTO base (directory,extension) VALUES ('./data','sqlite')";
$psa->qo($q);

if(!file_exists('psa.log')) {
	$file = new File('psa.log','w');
	unset($file);
}
unset($psa);

header('location: index.php');
exit;
?>
