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
		header('location: controller.php?cmd=base');
		exit;
	}
}

$cmd->setValue('qs');
$submit->setValue('Go!');

$html = new Page;
$html->setLanguage('en_EN');
$html->build();

$head = new Head;
$head->setTitle('PSA - query');
$head->setCss('./css/psa.css');
$head->setJs('./js/PSA.js');
$head->build();
	
$body = new Body;
$body->build();

include_once('./inc/menubar.php');

$body->line('Insert raw sql query : ');

$form = new Form;
$form->setAction('controller.php');
$form->build();

$inp_text = new Textarea;
$inp_text->setRows(15);
$inp_text->setCols(70);
$inp_text->setName('qs');
$inp_text->setId('to_text');

$inp_text->build();

$body->line();

$cmd->build();
$submit->build();

unset($form);

$body->line('<hr />');

$psa =  new PDO("sqlite:./data/base.sqlite");
$q = "SELECT * FROM queries ORDER BY datum DESC LIMIT 10";
$tps = $psa->prepare($q);
$tps->execute();
$res = $tps->fetchAll();

if(!$res) {	
	$body->line('no queries found.');
} else {
	$table = new Table;
	$table->setClas('result');
	$table->build();

	$th = new Th;
	$th->add('database');
	$th->add('date - time');
	$th->add('query (click to copy in execution field)');
	$th->build();
	
	foreach($res as $item) {
		$tr = new Tr;
		if($item['fine'] == 0) {
			$tr->setGlobalClass('query_error');

			$tr->add($item['db']);
			$tr->add($item['datum']);
			$tr->add(str_repeat("&nbsp;",2).$item['qs']);
			
		} else {
		
			$tr->add($item['db']);
			$tr->add($item['datum']);
			$tr->add('<div class="qs">
				<a href="#" 
				onClick="PSA.to_text(\''.str_replace('"',"&&",str_replace("'","##",trim(str_replace("\r\n"," ",$item['qs'])))).'\');">'.nl2br($item['qs']).'</a></div>');
		}
		$tr->build();
	}
	unset($table);
}
unset($psa);

/**/
include_once('./inc/footer.php');
unset($body);
unset($html);