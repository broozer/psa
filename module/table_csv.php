<?php

/**
*¨[type] file
* [name] table_csv.php
* [package] psa
* [since] 2012.11.07 
*/

// PAGING
if(!$sessie->isS('bottom')) {
	$sessie->setS('bottom',0);
}

$sql = new LitePDO('sqlite:'
	.$sessie->getS('psa-dir').'/'
	.$sessie->getS('psa-db').'.'
	.$sessie->getS('psa-ext').'');


$q = "PRAGMA table_info('".$req->get('table')."')";
$sql->qo($q);
$res = $sql->fo();

$pk = false;

foreach($res as $item) {
	if($item->name == 'id') {
		$pk = true;
	} else {
		$col[] = $item->name;
	}
}


if($pk) {
	$q = "SELECT * FROM ".$req->get('table')." ";
} else {
	$q = "SELECT ROWID as id,* FROM ".$req->get('table')."  ";
}

$sql->qo($q);

$res = $sql->fo();

$html = new Page;
 
$html->setLanguage('nl_NL');
$html->build();

$head = new Head;
$head->setCharset('UTF-8');
$head->setTitle('PSA - csv');
$head->setCss('./css/psa.css');
$head->setjs('./js/PSA.js');
$head->build();

$body = new Body;
$body->build();

include_once('./inc/menubar.php');

$body->line('<h3>Table : '.$req->get('table').'</h3>');

$odd = FALSE;
if(!$res) {
	$body->line('Table does not contain records');
} else {
	$string = '';
	foreach($res as $item) {
		$linear = (array)$item;
		$keyar = array_keys($linear);
		// var_dump($keyar);
		for($i=0;$i<sizeof($keyar);++$i) {
			$string .= "'".$linear[$keyar[$i]]."';";
		}
		
		$string .= '<br>';
		$body->line($string);
		$string = '';
	}
	
	unset($table);
}

$body->line('</div>');
include_once('./inc/footer.php');
unset($body);
unset($html);
?>