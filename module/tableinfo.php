<?php

/**
* [type] file
* [name] tableinfo.php
* [package] psa
* [since] 2010.10.20
*/

// $req->dump();

$sql = new LitePDO('sqlite:'
	.$sessie->getS('psa-dir').'/'
	.$sessie->getS('psa-db').'.'
	.$sessie->getS('psa-ext').'');

$q = "PRAGMA table_info('".$req->get('table')."')";

$sql->qo($q);
$res = $sql->fo();

// var_dump($res);

$html = new Html;
$html->setDoctype('xhtml-strict');
$html->setLanguage('nl_NL');
$html->build();

$head = new Head;
$head->setCharset('UTF-8');
$head->setTitle('PSA - show table info for '.$req->get('table'));
$head->setCss('./css/psa.css');
$head->build();

$body = new Body;
$body->build();

include_once('./inc/menubar.php');

$body->line('<p class="struct">Structure for table : <b>'.$req->get('table').'</b></p>');
$table = new Table;
$table->setClas('result');
$table->setId('listing');
$table->build();

$th = new Th;
$th->addElement('name');
$th->addElement('type');
$th->addElement('size');
$th->addElement('null allowed');
$th->addElement('default');
$th->build();

$odd = TRUE;

foreach($res as $item) {
			
	$pos = strpos($item->type,'(');
	if(!$pos) {
		$type = $item->type;
		$size = '-';
	} else {
		$type = substr($item->type,0,$pos);
		$size = substr($item->type,$pos+1,-1);
	}
	$test = strlen($type);
	if($test < 1) {
		$type = '<span class="red">NOT DEFINED</span>';
	}
	
	$dflt =  trim(gettype($item->dflt_value));
	if($dflt == 'NULL') {
		$dflt = '-';
	} else {
		$dflt = $item->dflt_value;
	}

	if($item->notnull == 0) {
		$nn = 'Y';
	} else {
		$nn = 'N';
	}

	if($item->pk == 0) {
		$name = $item->name;
	} else {
		$name = $item->name.' <span class="red">(PK)</span>';
		$nn = '-';
	}

	
	$tr = new Tr;
	if($odd) {
		$tr->setGlobalClass('even');
		$odd = FALSE;
	} else {
		$tr->setGlobalClass('odd');
		$odd = TRUE;
	}
	$tr->addElement($name);
	$tr->addElement($type);
	$tr->setClas('rechts');
	$tr->addElement($size);
	$tr->setClas('center');
	$tr->addElement($nn);
	$tr->addElement($dflt);
	$tr->build();
}

unset($table);

$body->line('<hr />');
$q = "SELECT sql FROM sqlite_master WHERE type = 'table' AND name = '".$req->get('table')."' ";
$sql->qo($q);
$res = $sql->fo_one();

echo $res->sql;

$body->line('</div>');
unset($body);
unset($html);
?>