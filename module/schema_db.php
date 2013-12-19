<?php

/**
*¨[type] file
* [name] schema_db.php
* [package] psa
* [since] 2013.07.29 
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


// PAGING
if(!$sessie->isS('bottom')) {
	$sessie->setS('bottom',0);
}

$sql = new LitePDO('sqlite:'
	.$sessie->getS('psa-dir').'/'
	.$sessie->getS('psa-db').'.'
	.$sessie->getS('psa-ext').'');


$q = "SELECT name FROM sqlite_master WHERE type = 'table' ORDER BY name";
$sql->qo($q);
$res = $sql->fo();

// echo "BOTTOM WAARDE  : <b><h1>".$sessie->getS('bottom')."</h1></b>"; 
$html = new Page;
 
$html->setLanguage('nl_NL');
$html->build();

$head = new Head;
$head->setCharset('UTF-8');
$head->setTitle('PSA - database schema');
$head->setCss('./css/psa.css','screen');
$head->setCss('./css/psaprint.css','print');
$head->setjs('./js/PSA.js');
$head->build();

$body = new Body;
$body->build();

include_once('./inc/menubar.php');

if(!$res) {
	$body->line('no tables defined yet');
} else {
	
	foreach($res as $item) {

		$body->line('<div class="schema"><h3>'.$item->name.'</h3>');
		
		$q_fields = "PRAGMA table_info('".$item->name."')";

		$sql->qo($q_fields);
		$res_fields = $sql->fo();

		$table = new Table;
		$table->setClas('result_schema');
		$table->setId('listing');
		$table->build();
		
		$th = new Th;
		$th->add('name');
		$th->add('type');
		$th->add('size');
		$th->add('null allowed');
		$th->add('default');
		$th->build();

		$odd = TRUE;
		
		foreach($res_fields as $item_fields) {
						
			$pos = strpos($item_fields->type,'(');
			if(!$pos) {
				$type = $item_fields->type;
				$size = '-';
			} else {
				$type = substr($item_fields->type,0,$pos);
				$size = substr($item_fields->type,$pos+1,-1);
			}
			$test = strlen($type);
			if($test < 1) {
				$type = '<span class="red">NOT DEFINED</span>';
			}
			
			$dflt =  trim(gettype($item_fields->dflt_value));
			if($dflt == 'NULL') {
				$dflt = '-';
			} else {
				$dflt = $item_fields->dflt_value;
			}
		
			if($item_fields->notnull == 0) {
				$nn = 'Y';
			} else {
				$nn = 'N';
			}
		
			if($item_fields->pk == 0) {
				$name = $item_fields->name;
			} else {
				$name = $item_fields->name.' <span class="red">(PK)</span>';
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
			$tr->add($name);
			$tr->add($type);
			$tr->setClas('rechts');
			$tr->add($size);
			$tr->setClas('center');
			$tr->add($nn);
			$tr->add($dflt);
			$tr->build();
		}
		
		unset($table);
		$body->line('</div>');
	}
}



$body->line('</div>');

include_once('./inc/footer.php');

unset($body);
unset($html);
