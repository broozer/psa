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
		header('location: controller.php?cmd=base');
		exit;
	}
}

if($req->is('db')) {
	if($req->get('db') == '') {
		$sessie->setS('psa-error','No database set.');
		header('location: controller.php?cmd=base');
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
// unset($sql);

$html = new Page;
 
$html->setLanguage('nl_NL');
$html->build();

$head = new Head;
$head->setCharset('UTF-8');
$head->setTitle('PSA - show tables');
$head->setCss('./css/psa.css');
$head->setjs('./js/PSA.js');
$head->build();

$body = new Body;
$body->build();

include_once('./inc/menubar.php');

$body->line();

$link = new Link;
$link->setHref('controller.php?cmd=table_add');
$link->setClas('butter');
$link->setName('Add table');
$link->build();

$body->line('<hr>');

if(!$res) {
	$body->line('No tables defined.');
} else {

	$body->line('<h3>List tables</h3>');
	
	$table = new Table;
	$table->setClas('result');
	$table->build();
	
	foreach($res as $item) {

		if($item->name == 'sqlite_sequence') {
			continue;
		}
		$struct = new Link;
		$struct->setHref('controller.php?cmd=tableinfo&table='.$item->name);
		$struct->setName('Structure');

		$browse = new Link;
		$browse->setHref('controller.php?cmd=table_browse&table='.$item->name);
		$browse->setName('Browse');

		$dump = new Link;
		$dump->setHref('controller.php?cmd=table_dump&table='.$item->name);
		$dump->setName('Dump');

		$csv = new Link;
		$csv->setHref('controller.php?cmd=table_csv&table='.$item->name);
		$csv->setName('CSV');
		
		$drop = new Link;
		$drop->setHref('controller.php?cmd=drop_table&table='.$item->name);
		$drop->setName('Drop');
		$drop->setJs(' onclick="return PSA.really_drop(\'table\');" ');
		
		$tr = new Tr;
		$tr->add($item->name);
		$tr->add($struct->dump());
		$tr->add($browse->dump());
		$tr->add($dump->dump());
		$tr->add($csv->dump());
		$tr->add($drop->dump());
		$tr->build();
	}
	
	unset($table);
}

$body->line('<hr>');

$q = "SELECT name FROM sqlite_master WHERE type = 'view' ORDER BY name";
$sql->qo($q);
$res = $sql->fo();

if(!$res) {
	$body->line('No views defined.');
} else {

	$body->line('<h3>List views</h3>');
	
	$table = new Table;
	$table->setClas('result');
	$table->build();
	
	foreach($res as $item) {

		if($item->name == 'sqlite_sequence') {
			continue;
		}
		$struct = new Link;
		$struct->setHref('controller.php?cmd=tableinfo&table='.$item->name.'&view=true');
		$struct->setName('Structure');
		
		$browse = new Link;
		$browse->setHref('controller.php?cmd=table_browse&table='.$item->name.'&view=true');
		$browse->setName('Browse');

		$dump = new Link;
		$dump->setHref('controller.php?cmd=table_dump&table='.$item->name.'&view=true');
		$dump->setName('Dump');

		$drop = new Link;
		$drop->setHref('controller.php?cmd=drop_view&table='.$item->name.'&view==true');
		$drop->setName('Drop');
		$drop->setJs(' onclick="return PSA.really_drop(\'view\');" ');
		
		$tr = new Tr;
		$tr->add($item->name);
		$tr->add($struct->dump());
		$tr->add($browse->dump());
		$tr->add($dump->dump());
		$tr->add($drop->dump());
		$tr->build();
	}
	
	unset($table);
}

include_once('./inc/footer.php');

unset($body);
unset($html);
?>