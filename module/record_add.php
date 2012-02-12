<?php

/**
*¨[type] file
* [name] record_add.php
* [package] psa
* [since] 2012.02.12
* [expl] 
*/
# TODO: submit and cmd 

$submit->setValue('Update');
$cmd->setValue('record_add_do');

/**/
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
	}
	$col[] = $item->name;
}

/*
if($pk) {
	$q = "SELECT * FROM ".$req->get('table')." WHERE id = ".$req->get('id');
} else {
	$q = "SELECT * FROM ".$req->get('table')." WHERE ROWID = ".$req->get('id');
}

$sql->qo($q);
$res = $sql->fo_one();
*/
// var_dump($res);

$html = new Page;
 
$html->setLanguage('nl_NL');
$html->build();

$head = new Head;
$head->setCharset('UTF-8');
$head->setTitle('PSA - edit record');
$head->setCss('./css/psa.css');
$head->build();

$body = new Body;
$body->build();

include_once('./inc/menubar.php');

$form = new Form;
$form->setAction('index.php');
$form->build();

$table = new Table;
$table->build();

$i = 0;
/**/

$inp = new Input;
$inp->setName('data_id');
$inp->setValue(-1);
$inp->setType('hidden');
/**/

$data_table = new Input;
$data_table->setName('data_table');
$data_table->setValue($req->get('table'));
$data_table->setType('hidden');

$tr = new Tr;
$tr->add($inp->dump());
$tr->add($data_table->dump());
$tr->add($cmd->dump());
$tr->build();


foreach($col as $item) {

	
	if($item == 'id') {
		++$i;
		continue;
	}
	
	// $length = strlen($item);
	$size = 50;
	/*
	if($length < 10) {
		$size = 10;
	}
	*/
	
	$inp = new Input;
	$inp->setName($item);
	// $inp->setValue($item);
	$inp->setSize(50);
	$inp->setMaxlength(128);
	
	/**/
	
	$tr = new Tr;
	$tr->add($item);
	$tr->add($inp->dump());
	$tr->build();
	++$i;
	/**/
	
}

$tr = new Tr;
$tr->add('&nbsp;');
$tr->add($submit->dump());
$tr->build();

unset($table);
unset($form);


include_once('./inc/footer.php');
unset($body);
unset($html);

?>