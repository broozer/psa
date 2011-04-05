<?php

/**
* [type] file
* [name] table_add.php
* [package] psa
* [since] 2011.02.10
*/

// $req->dump();

$sql = new LitePDO('sqlite:'
	.$sessie->getS('psa-dir').'/'
	.$sessie->getS('psa-db').'.'
	.$sessie->getS('psa-ext').'');

$html = new Html;
$html->setDoctype('xhtml-strict');
$html->setLanguage('nl_NL');
$html->build();

$head = new Head;
$head->setCharset('UTF-8');
$head->setTitle('PSA - add table');
$head->setCss('./css/psa.css');
$head->build();

$body = new Body;
$body->build();

include_once('./inc/menubar.php');

$body->line('<h2>ONLY DISPLAY !!</h2>');

$name = new Input;
$name->setName('name');
$name->setSize(50);
$name->setMaxlength(128);

$body->line('<span class="vet">Table name</span><br /> ');
$body->line($name->dump());


$body->line('<hr />');

$body->line('<span class="vet">Fields</span><br /> ');

$table = new Table;
$table->setClas('result');
$table->build();

$th = new Th;
$th->addElement('name');
$th->addElement('type');
$th->addElement('primary');
$th->addElement('size');
$th->addElement('null');
$th->addElement('default');
$th->build();

// include js 
$i = 0;
for($i=0;$i<8;++$i) {
	$colname = new Input;
	$colname->setName('colname'.$i);
	$colname->setSize(30);
	$colname->setMaxlength(128);

	$coltype = new Select;
	$coltype->setName('coltype'.$i);
	$coltype->setSize(1);

	$coltype->addElement('VARCHAR','VARCHAR');
	$coltype->addElement('INTEGER','INTEGER');
	$coltype->addElement('FLOAT','FLOAT');
	$coltype->addElement('TEXT','TEXT');
	$coltype->addElement('DATETIME','DATETIME');

	$colprime = new Input;
	$colprime->setName('colprime'.$i);
	$colprime->setType('checkbox');

	$colsize = new Input;
	$colsize->setName('colsize'.$i);
	$colsize->setSize(7);
	$colsize->setMaxlength(7);

	$colnull = new Input;
	$colnull->setName('colnull'.$i);
	$colnull->setType('checkbox');

	$coldefault = new Input;
	$coldefault->setName('coldefault'.$i);
	$coldefault->setSize(30);
	$coldefault->setMaxlength(128);
	
	$tr = new Tr;
	$tr->addElement($colname->dump());
	$tr->addElement($coltype->dump());
	$tr->setClas('center');
	$tr->addElement($colprime->dump());
	$tr->setClas('center');
	$tr->addElement($colsize->dump());
	$tr->setClas('center');
	$tr->addElement($colnull->dump());
	$tr->addElement($coldefault->dump());
	$tr->build();
}
	


unset($table);
$body->line('<hr /></div>');
unset($body);
unset($html);
?>