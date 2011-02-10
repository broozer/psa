<?php

/**
*¨[type] file
* [name] query.php
* [package] psa
* [since] 2010.09.22 - ok
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

$cmd->setValue('qs');
$submit->setValue('Go!');

$html = new Html;
$html->setDoctype('xhtml-strict');
$html->setLanguage('nl_NL');
$html->build();

$head = new Head;
$head->setCharset('UTF-8');
$head->setTitle('PSA - query');
$head->setCss('./css/psa.css');
$head->setJs('./js/PSA.js');
$head->build();

$body = new Body;
$body->build();

include_once('./inc/menubar.php');

$form = new Form;
$form->setAction('index.php');
$form->build();

$inp_text = new Textarea;
$inp_text->setRows(15);
$inp_text->setCols(100);
$inp_text->setName('qs');
$inp_text->setId('to_text');

$inp_text->build();

$body->line();

$cmd->build();
$submit->build();

unset($form);

$body->line('<hr />');

$psa =  new PDO("sqlite:./data/base.sqlite");
$q = "SELECT * FROM queries ORDER BY datum DESC LIMIT 20";
$tps = $psa->prepare($q);
$tps->execute();
$res = $tps->fetchAll();

if(!$res) {	
	$body->line('no queries found.');
} else {
	$table = new Table;
	$table->setClas('result');
	$table->build();
	
	foreach($res as $item) {
		$tr = new Tr;
		$tr->addElement($item['db']);
		$tr->addElement($item['datum']);
		$tr->addElement('<div class="qs">
			<a href="#" 
			onClick="PSA.to_text(\''.str_replace("'","##",trim(str_replace("\r\n"," ",$item['qs']))).'\');">'.nl2br($item['qs']).'</a></div>');
		$tr->build();
	}
	unset($table);
}
unset($psa);

/**/
$body->line('</div>');
unset($body);
unset($html);
?>