<?php

/**
* [type] file
* [name] drop_column.php
* [package] psa
* [since] 2012.01.21
* [expl] action file !!
*/

/*
$req->dump();
echo '<hr />';
*/

$sql = new LitePDO('sqlite:'
	.$sessie->getS('psa-dir').'/'
	.$sessie->getS('psa-db').'.'
	.$sessie->getS('psa-ext').'');
	
// get list of existing columns 
// copy to temp leaving out the column to be deleted

$q = "PRAGMA table_info('".$req->get('table')."')";

$sql->qo($q);
$rescols = $sql->fo();

$string = '';
$begin = true;
$colums = '';

foreach($rescols as $item) {

	if($item->name === $req->get('col')) {
		continue;
	}
	
	/* DEBUG: echo '<hr>';
	var_dump($item);
	echo '<br>';
	echo '<b>'.$item->name.'</b><br>';
	*/
	
	$pos = strpos($item->type,'(');
	if(!$pos) {
		$type = $item->type;
		$size = '';
	} else {
		$type = substr($item->type,0,$pos);
		$size = substr($item->type,$pos+1,-1);
	}
	$test = strlen($type);
	if($test < 1) {
		$type = '<span class="red">NOT DEFINED</span>';
	}

	if($item->pk !== '0') {
		$type = $type." PRIMARY KEY AUTOINCREMENT";
		$nn = '-';
		
	}

	if($size !== '') {
		$size = '('.$size.')';
	}
	
	$dflt =  trim(gettype($item->dflt_value));
	if($dflt == 'NULL') {
		$dflt = '';
	} else {
		$dflt = 'DEFAULT '.$item->dflt_value;
	}

	if($item->notnull == 0) {
		$nn = 'NULL';
	} else {
		$nn = 'NOT NULL';
	}

	if($begin) {
		$string = $item->name.' '.$type.' '.$size;
		$columns = $item->name;
		$begin = false;
		
	} else {
		$string = $string.', '.$item->name.' '.$type.$size.' '.$nn.' '.$dflt;
		$columns .= ', '.$item->name;
	}

	// echo $string.'<br>';

	
}

$tmpstring = 'CREATE TEMPORARY TABLE tmp_'.$req->get('table').' ('.$string.');';
/* DEBUG: 
echo '<hr>';

echo $tmpstring;
echo '<hr>';
echo $columns;
echo '<hr>';
/**/
/**/
$q = "BEGIN TRANSACTION";
$sql->qo($q);
/**/
$q = $tmpstring;
if(!$sql->qo($q)) {
	$q = "ROLLBACK";
	$sql->qo($q);
	// $sessie->setS('psa_error','Problem creating temporary table in [drop_column.php]');
	header('location: index.php?cmd=tableinfo&table='.$req->get('table'));
	exit;
}

$q = "INSERT INTO tmp_".$req->get('table')." SELECT ".$columns." FROM ".$req->get('table')." ";

if(!$sql->qo($q)) {
	$q = "ROLLBACK";
	$sql->qo($q);
	header('location: index.php?cmd=tableinfo&table='.$req->get('table'));
	exit;
}

$q = "DROP TABLE ".$req->get('table')." ";
if(!$sql->qo($q)) {
	$q = "ROLLBACK";
	$sql->qo($q);
	header('location: index.php?cmd=tableinfo&table='.$req->get('table'));
	exit;
}

$q = 'CREATE TABLE '.$req->get('table').' ('.$string.') ';
if(!$sql->qo($q)) {
	$q = "ROLLBACK";
	$sql->qo($q);
	header('location: index.php?cmd=tableinfo&table='.$req->get('table'));
	exit;
}

$q = "INSERT INTO ".$req->get('table')." SELECT ".$columns." FROM tmp_".$req->get('table')." ";
if(!$sql->qo($q)) {
	$q = "ROLLBACK";
	$sql->qo($q);
	header('location: index.php?cmd=tableinfo&table='.$req->get('table'));
	exit;
}

$q = "DROP TABLE tmp_".$req->get('table')." ";
if(!$sql->qo($q)) {
	$q = "ROLLBACK";
	$sql->qo($q);
	header('location: index.php?cmd=tableinfo&table='.$req->get('table'));
	exit;
}
/**/
$q = "COMMIT";
$sql->qo($q);
/**/
/**/
header('location: index.php?cmd=tableinfo&table='.$req->get('table'));
exit;
/**/

?>