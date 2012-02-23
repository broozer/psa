<?php

/**
* [type] file
* [name] index_add.php
* [package] psa
* [since] 2011.02.22
*/


$submit->setValue('Create');
$cmd->setValue('index_add_do');

$sql = new LitePDO('sqlite:'
	.$sessie->getS('psa-dir').'/'
	.$sessie->getS('psa-db').'.'
	.$sessie->getS('psa-ext').'');

$fields = Array();

$q = "PRAGMA table_info('".$req->get('table')."')";

$sql->qo($q);
$res = $sql->fo();

foreach($res as $item) {
	$fields[] = $item->name;
}

$html = new Page;
 
$html->setLanguage('nl_NL');
$html->build();

$head = new Head;
$head->setCharset('UTF-8');
$head->setTitle('PSA - create index');
$head->setCss('./css/psa.css');
$head->setJs('./js/PSA.js');
$head->build();

$body = new Body;
$body->build();

include_once('./inc/menubar.php');

$body->line("Index creation on table : <b>".$req->get('table')."</b><br>");

$form = new Form;
$form->setAction('index.php');
$form->setJs(' onsubmit="return PSA.indexcol();" ');
$form->build();

// TODO: check if table name already exists
$name = new Input;
$name->setName('idxname');
$name->setSize(50);
$name->setMaxlength(128);
$name->setId('idxname');

$body->line('Name : '.$name->dump().' '.$cmd->dump().'<br>');

for($i=0;$i<sizeof($fields);++$i) {
	$select = new Select;
	$select->setName('col'.$i);
	$select->setSize(1);
	$select->add('','-');
	for($j=0;$j<sizeof($fields);++$j) {
		$select->add($fields[$j],$fields[$j]);
	}
	$body->line('index on : '.$select->dump().'<br>');
}

$submit->build();

$tblname = new Input;
$tblname->setName('tblname');
$tblname->setSize(128);
$tblname->setValue($req->get('table'));
$tblname->setType('hidden');

$tblname->build();

unset($form);

$body->line('</div>');
include_once('./inc/footer.php');
unset($body);
unset($html);
?>