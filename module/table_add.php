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
$head->setJs('./js/PSA.js');
$head->build();

$body = new Body;
$body->build();

include_once('./inc/menubar.php');

$body->line('<h2>ONLY DISPLAY !!</h2>');

$name = new Input;
$name->setName('name');
$name->setSize(50);
$name->setMaxlength(128);
$name->setId('tblname');

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

$colname = new Input;
$colname->setName('colname');
$colname->setSize(30);
$colname->setMaxlength(128);
$colname->setId('colname');

$coltype = new Select;
$coltype->setName('coltype');
$coltype->setSize(1);
$coltype->setId('coltype');

$coltype->addElement('VARCHAR','VARCHAR');
$coltype->addElement('INTEGER','INTEGER');
$coltype->addElement('FLOAT','FLOAT');
$coltype->addElement('TEXT','TEXT');
$coltype->addElement('DATETIME','DATETIME');

$colprime = new Input;
$colprime->setName('colprime');
$colprime->setType('checkbox');
$colprime->setId('colprime');

$colsize = new Input;
$colsize->setName('colsize');
$colsize->setSize(7);
$colsize->setMaxlength(7);
$colsize->setId('colsize');

$colnull = new Input;
$colnull->setName('colnull');
$colnull->setType('checkbox');
$colnull->setId('colnull');

$coldefault = new Input;
$coldefault->setName('coldefault');
$coldefault->setSize(30);
$coldefault->setMaxlength(128);
$coldefault->setId('coldefault');

$fieldadd = new Input;
$fieldadd->setType('button');
$fieldadd->setName('fieldadd');
$fieldadd->setValue('add');
$fieldadd->setJs(' onclick="PSA.addField();" ');

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
$tr->addElement($fieldadd->dump());
$tr->build();

unset($table);
$body->line('<hr />');

$table = new Table();
$table->setId('tfields');

unset($table);

$body->line('</div>');

unset($body);
unset($html);
?>