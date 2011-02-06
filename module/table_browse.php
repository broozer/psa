<?php

/**
*¨[type] file
* [name] table_browse.php
* [package] psa
* [since] 2010.10.20 -ok 
*/

// PAGING
if(!$sessie->isS('bottom')) {
	$sessie->setS('bottom',0);
}

$sql = new LitePDO('sqlite:'
	.$sessie->getS('psa-dir').'/'
	.$sessie->getS('psa-db').'.'
	.$sessie->getS('psa-ext').'');

$q = "SELECT count(*) as count FROM ".$req->get('table')." ";
$sql->qo($q);
$res = $sql->fo_one();
$records = $res->count;
$pages = floor($records/LIMIT);
$lastpage = round($pages,0)*LIMIT;

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

// echo 'lastpage val : '.$lastpage.'<hr />';

if($req->get('direction') == 'last') {
	$sessie->setS('bottom',$lastpage);
}

if($req->get('direction') == 'first') {
	$sessie->setS('bottom',0);
}

if($req->get('direction') == 'next') {
	$bottom = $sessie->getS('bottom')+ LIMIT;
	
	if($bottom <= $lastpage) {
		$sessie->setS('bottom',$bottom);
	}
}

if($req->get('direction') == 'previous') {
	$bottom = $sessie->getS('bottom') - LIMIT;
	if($bottom >= 0) {
		$sessie->setS('bottom',$bottom);
	}
}

if($pk) {
	$q = "SELECT * FROM ".$req->get('table')." LIMIT ".$sessie->getS('bottom').",".LIMIT." ";
} else {
	$q = "SELECT ROWID as id,* FROM ".$req->get('table')." LIMIT ".$sessie->getS('bottom').",".LIMIT." ";
}

$sql->qo($q);

$res = $sql->fo();

// echo "BOTTOM WAARDE  : <b><h1>".$sessie->getS('bottom')."</h1></b>"; 
$html = new Html;
$html->setDoctype('xhtml-strict');
$html->setLanguage('nl_NL');
$html->build();

$head = new Head;
$head->setCharset('UTF-8');
$head->setTitle('PSA - query results');
$head->setCss('./css/psa.css');
$head->setjs('./js/PSA.js');
$head->build();

$body = new Body;
$body->build();

include_once('./inc/menubar.php');

$body->line('<h3>Table : '.$req->get('table').'</h3>');

$odd = FALSE;
if(!$res) {
	$body->line('Table does not contain records');
} else {
	$firstlink = new Link;
	$firstlink->setHref('index.php?cmd=table_browse&table='.$req->get('table').'&direction=first');
	$firstlink->setName('[<<--]');
	$firstlink->build();
	
	$previous = new Link;
	$previous->setHref('index.php?cmd=table_browse&table='.$req->get('table').'&direction=previous');
	$previous->setName('[<]');
	$previous->build();
	
	$next = new Link;
	$next->setHref('index.php?cmd=table_browse&table='.$req->get('table').'&direction=next');
	$next->setName('[>]');
	$next->build();
	
	$lastlink = new Link;
	$lastlink->setHref('index.php?cmd=table_browse&table='.$req->get('table').'&direction=last');
	$lastlink->setName('[-->>]');
	$lastlink->build();
	
	$low = $sessie->getS('bottom') + 1;
	$high = $sessie->getS('bottom') + LIMIT;
	
	if($high > $records) {
		$high = $records;
	}
	
	$body->line(' (total # of records : <b> '
		.$records
		.'</b> -- showing <b>'
		.$low
		.'</b> till <b>'
		.$high
		.'</b>)<br />');
	
	$titles = FALSE;
	
	$table = new Table;
	$table->setClas('result');
	$table->setId('listing');
	$table->build();
	foreach($res as $item) {
		/**/
		if(!$titles) {
			$tr = new Th;
			$tr->addElement('edit');
			$tr->addElement('delete');
			if(!$pk) {
				$tr->addElement('ROWID');
			}
			// $names = array_keys(get_object_vars($item));
			for($i=0;$i<sizeof($col);++$i) {
				$tr->addElement($col[$i]);
			}
			$tr->build();
			$titles = TRUE;
		}
		/**/
		$tr = new Tr;
		if($odd) {
		$tr->setGlobalClass('even');
		$odd = FALSE;
		} else {
			$tr->setGlobalClass('odd');
			$odd = TRUE;
		}
		$edit = new Link;
		$edit->setHref('index.php?cmd=edit_record&table='.$req->get('table').'&id='.$item->id);
		$edit->setName('edit');
		// $edit->setTarget('edit_del');
	
		$del = new Link;
		$del->setHref('index.php?cmd=drop_record&table='.$req->get('table').'&id='.$item->id);
		$del->setName('del');
		$del->setJs(' onclick="return PSA.really_drop(\'record\');" ');
		
		$tr->addElement($edit->dump());
		$tr->addElement($del->dump());
		
		foreach($item as $data) {
			$tr->addElement($data);
		}
		$tr->build();
	}
	
	unset($table);
}

$body->line('</div>');
unset($body);
unset($html);
?>