<?php

/**
* [type] file
* [name] table_add.php
* [package] psa
* [since] 2011.02.10
*/

// $req->dump();
// begin with a fresh state

$base_sql = new LitePDO('sqlite:./data/base.sqlite');
$base_q = "DELETE FROM temp_table_fields";
$base_sql->qo($base_q);

unset($base_sql);

$sql = new LitePDO('sqlite:'
	.$sessie->getS('psa-dir').'/'
	.$sessie->getS('psa-db').'.'
	.$sessie->getS('psa-ext').'');

$html = new Page;
 
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

// TODO: check if table name already exists
$name = new Input;
$name->setName('tblname');
$name->setSize(50);
$name->setMaxlength(128);
$name->setId('tblname');

$body->line('<span class="vet">Table name</span><br /> ');
$body->line($name->dump());

$create = new Link;
$create->setHref('index.php?cmd=table_add_action');
$create->setName('<button>Create</button>');
$body->line($create->dump());

$body->line('<hr />');

$body->line('<span class="vet">Fields</span><br /> ');

$table = new Table;
$table->setClas('result');
$table->build();

$th = new Th;
$th->add('name');
$th->add('type');
$th->add('primary');
$th->add('size');
$th->add('null');
$th->add('default');
$th->build();

$colname = new Input;
$colname->setName('colname');
$colname->setSize(25);
$colname->setMaxlength(128);
$colname->setId('colname');

$coltype = new Select;
$coltype->setName('coltype');
$coltype->setSize(1);
$coltype->setId('coltype');

$coltype->add('VARCHAR','VARCHAR');
$coltype->add('INTEGER','INTEGER');
$coltype->add('FLOAT','FLOAT');
$coltype->add('TEXT','TEXT');
$coltype->add('DATETIME','DATETIME');

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
$coldefault->setSize(25);
$coldefault->setMaxlength(128);
$coldefault->setId('coldefault');

$fieldadd = new Input;
$fieldadd->setType('button');
$fieldadd->setName('fieldadd');
$fieldadd->setValue('add');
$fieldadd->setJs(' onclick="PSA.addField();" ');

$tr = new Tr;
$tr->add($colname->dump());
$tr->add($coltype->dump());
$tr->setClas('center');
$tr->add($colprime->dump());
$tr->setClas('center');
$tr->add($colsize->dump());
$tr->setClas('center');
$tr->add($colnull->dump());
$tr->add($coldefault->dump());
$tr->add($fieldadd->dump());
$tr->build();

unset($table);
$body->line('<hr />');

$table = new Table();
$table->setId('tfields');

unset($table);

$body->line('<div id="ttshow"></div>');

$body->line('</div>');
include_once('./inc/footer.php');
unset($body);
unset($html);
?>