<?php

/**
* [type] file
* [name] index_add_do.php
* [package] psa
* [since] 2012.02.22
* [expl] 
*/
$req->dump();

$ar = $req->to_arr('ol');

$sql = new LitePDO('sqlite:'
	.$sessie->getS('psa-dir').'/'
	.$sessie->getS('psa-db').'.'
	.$sessie->getS('psa-ext').'');

$collist = '';
// string creation
foreach($ar as $item) {
	if(trim($item) === '') {
		continue;
	} else {
		$collist = $collist.$item.',';
	}
}

if(trim($collist) === '') {
	$sessie->setS('psa-error','No indexable columns given, no index created.');
	header('location: index.php?cmd=tableinfo&table='.$req->get('tblname'));
	exit;
} else {
	$collist = substr($collist,0,-1);
	
	$q = "CREATE INDEX ".$req->get('idxname')." ON ".$req->get('tblname')."(".$collist.")";
	$sql->qo($q);
	
	$sessie->setS('psa-error','Index "'.$req->get('idxname').'" created.');
	header('location: index.php?cmd=tableinfo&table='.$req->get('tblname'));
	exit;
}


?>