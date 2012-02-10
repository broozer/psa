<?php

/**
*¨[type] file
* [name] table.php
* [package] psa
* [since] 2010.09.22 -ok
*/
if(!$sessie->isS('psa-db')) {
	if($req->get('db')) {
		$sessie->setS('psa-db',urldecode($req->get('db')));
	} else {
		$sessie->setS('psa-error','No database set.');
		header('location: index.php?cmd=base');
		exit;
	}
}

if($req->is('db')) {
	if($req->get('db') == '') {
		$sessie->setS('psa-error','No database set.');
		header('location: index.php?cmd=base');
		exit;
	}
	$sessie->setS('psa-db',urldecode($req->get('db')));
}


if(isset($sql)) {
	'SQL is set<hr />';
	unset($sql);
} 

if(isset($psa)) {
	'PSA is set<hr />';
	unset($psa);
}

$sql = new LitePDO('sqlite:'
	.$sessie->getS('psa-dir').'/'
	.$sessie->getS('psa-db').'.'
	.$sessie->getS('psa-ext').'');

// var_dump($sql);

$q = "SELECT name FROM sqlite_master WHERE type = 'table' ORDER BY name";
// echo $q;
// $sql->qo('PRAGMA table_info('.$req->get('name').')');

$sql->qo($q);
$res = $sql->fo();
unset($sql);

$html = new Page;
 
$html->setLanguage('nl_NL');
$html->build();

$head = new Head;
$head->setCharset('UTF-8');
$head->setTitle('PSA - show tables');
$head->setCss('./css/psa.css');
$head->build();

$body = new Body;
$body->build();

include_once('./inc/menubar.php');

$link = new Link;
$link->setHref('index.php?cmd=table_add');
$link->setName('Add table');
$link->build();

$body->line('<hr>');

if(!$res) {
	$body->line('No tables defined.');
} else {

	$table = new Table;
	$table->setClas('result');
	$table->build();
	
	foreach($res as $item) {

		if($item->name == 'sqlite_sequence') {
			continue;
		}
		$struct = new Link;
		$struct->setHref('index.php?cmd=tableinfo&table='.$item->name);
		$struct->setName('Structure');

		$browse = new Link;
		$browse->setHref('index.php?cmd=table_browse&table='.$item->name);
		$browse->setName('Browse');

		$dump = new Link;
		$dump->setHref('index.php?cmd=table_dump&table='.$item->name);
		$dump->setName('Dump');
		
		$tr = new Tr;
		$tr->add($item->name);
		$tr->add($struct->dump());
		$tr->add($browse->dump());
		$tr->add($dump->dump());
		$tr->build();
	}
	
	unset($table);
}

include_once('./inc/footer.php');

unset($body);
unset($html);
?>