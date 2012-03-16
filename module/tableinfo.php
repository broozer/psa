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

$html = new Page;
 
$html->setLanguage('nl_NL');
$html->build();

$head = new Head;
$head->setCharset('UTF-8');
$head->setTitle('PSA - show table info for '.$req->get('table'));
$head->setCss('./css/psa.css');
$head->setJs('./js/PSA.js');
$head->build();

$body = new Body;
$body->build();

include_once('./inc/menubar.php');

$body->line('<h3>Structure for table : <b>'.$req->get('table').'</b></h3>');
$table = new Table;
$table->setClas('result');
$table->setId('listing');
$table->build();

$th = new Th;
$th->add('name');
$th->add('type');
$th->add('size');
$th->add('null allowed');
$th->add('default');
$th->add('remove');
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
	$tr->add($name);
	$tr->add($type);
	$tr->setClas('rechts');
	$tr->add($size);
	$tr->setClas('center');
	$tr->add($nn);
	$tr->add($dflt);

	$test = 'haai';
	
	$dellink = new Link;
	$dellink->setHref('index.php?cmd=drop_column&amp;table='.$req->get('table').'&amp;col='.$item->name);
	$dellink->setName('[ del ]');
	$dellink->setJs(' onclick="return PSA.really_drop(\' column ['.$item->name.']\');" ');

	
	$tr->add($dellink->dump());
	$tr->build();
}

unset($table);

$body->line('<hr />');

$body->line('<h3>SQL create statement</h3>');

if($req->is('view')) {
	$q = "SELECT sql FROM sqlite_master WHERE type = 'view' AND name = '".$req->get('table')."' ";
} else {
	$q = "SELECT sql FROM sqlite_master WHERE type = 'table' AND name = '".$req->get('table')."' ";
}

$sql->qo($q);
$res = $sql->fo_one();

$body->line($res->sql);

$body->line('<hr>');

if(!$req->is('view')) {
	// $body->line('create indexes - overview indexes');
	$body->line('<h3>Indexes</h3>');
	
	$idxadd = new Link;
	$idxadd->setHref('index.php?cmd=index_add&table='.$req->get('table'));
	$idxadd->setName('Add index');
	$idxadd->build();
	
	$body->line();
	
	$q = "PRAGMA index_list(".$req->get('table').")";
	$sql->qo($q);
	$res = $sql->fo();
	
	if(!$res) {
		$body->line('No indexes defined<br>');
	} else {
		$table = new Table;
		$table->setClas('result');
		$table->build();
	
		$th = new Th;
		$th->add('Name');
		$th->add('Unique ?');
		$th->add('Columns');
		$th->add('&nbsp;');
		$th->build();
		
		foreach($res as $item) {
	
			if($item->unique == 1 ) {
				$uniq = 'Y';
			} else {
				$uniq = 'N';
			}
	
			$drop = new Link;
			$drop->setHref('index.php?cmd=drop_idx&idxname='.$item->name.'&table='.$req->get('table'));
			$drop->setName('[ drop ]');
			$drop->setJs(' onclick="return PSA.really_drop(\' index ['.$item->name.']\');" ');
			
			$tr = new Tr;
			if($odd) {
				$tr->setGlobalClass('even');
				$odd = FALSE;
			} else {
				$tr->setGlobalClass('odd');
				$odd = TRUE;
			}
	
			
			$tr->add($item->name);
			$tr->setClas('center');
			$tr->add($uniq);
			
			$q = "PRAGMA index_info(".$item->name.")";
			$sql->qo($q);
			$rescol = $sql->fo();
			$list = '';
			
			foreach($rescol as $itcol) {
				$list = $list.$itcol->name.' ,';
			}
	
			$tr->add(substr($list,0,-2));
			$tr->add($drop->dump());
			$tr->build();
			
		}
		unset($table);
	}
} else {
	$body->line('Views cannot be indexed.');
}

$body->line('</div>');
include_once('./inc/footer.php');
unset($body);
unset($html);
?>