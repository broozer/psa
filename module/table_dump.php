<?php

/**
*¨[type] file
* [name] table_dump.php
* [package] psa
* [since] 2011.03.07  
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

// echo "BOTTOM WAARDE  : <b><h1>".$sessie->getS('bottom')."</h1></b>"; 
$html = new Html;
$html->setDoctype('xhtml-strict');
$html->setLanguage('nl_NL');
$html->build();

$head = new Head;
$head->setCharset('UTF-8');
$head->setTitle('PSA - query results');
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
	
	foreach($res as $item) {
		$insert = 'INSERT INTO '.$req->get('table').' (';
		for($i=0;$i<sizeof($col);++$i) {
			// var_dump($col);
			// echo "$col[$i] - waarde = ".$item->$col[$i].'<br />';
			$insert .= $col[$i].', ';
			$vals[] = $item->$col[$i];
		}
		$insert = substr($insert,0,-2).") VALUES ('";
		// var_dump($vals);
		for($i=0;$i<sizeof($vals);++$i) {
			// var_dump($col);
			// echo "$col[$i] - waarde = ".$item->$col[$i].'<br />';
			$insert .= $vals[$i]."','";
			// $vals[] = $item->$col[$i];
		}
		$insert = substr($insert,0,-2).");";
		// echo '<hr />';
		echo $insert.'<br />';
		$insert = '';
		unset($vals);
		// echo '<hr />';

		
	}
	
	unset($table);
}

$body->line('</div>');
unset($body);
unset($html);
?>