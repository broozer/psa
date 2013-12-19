<?php

// table_add_action.php
// table create based on temp info

$sql = new LitePDO('sqlite:./data/base.sqlite');
$q = "SELECT * FROM temp_table_fields ORDER BY colprime DESC";
$sql->qo($q);
$res = $sql->fo();

if(!$res) {
	$sessie->setS('psa-error','No data found to create table');
	header('location: controller.php?cmd=table');
	exit;
}

$table = false;
$createstring = '';

// var_dump($res);

foreach($res as $item) {

	if(!$table) {
		$createstring = 'CREATE TABLE IF NOT EXISTS "'.$item->tblname.'" (';
		$table = true;
		$tablename = $item->tblname;
	}

	$createstring .= '"'.$item->colname.'" ';

	$createstring .= " ".$item->coltype;
	
	if($item->colsize !== '') {
		$createstring .= '('.$item->colsize.')';
	}

	if($item->colprime == 1) {
		$createstring .= " PRIMARY KEY ";
	} else {
		if($item->colnull == 1) {
			$createstring .= ' NULL ';
		} else {
			$createstring .= ' NOT NULL ';
		}

		if($item->coldefault !== '') {
			$createstring .= ' DEFAULT "'.$item->coldefault.'" ';
		}
	}

	
	
	$createstring .= ', '; 

	/*
	echo $createstring;
	echo '<br>';
	/**/
}

$createstring = substr($createstring,0,-2).')';
/*
	echo $createstring;
	echo '<br>';
	/**/
	
unset($sql);

$sql = new LitePDO('sqlite:'
	.$sessie->getS('psa-dir').'/'
	.$sessie->getS('psa-db').'.'
	.$sessie->getS('psa-ext').'');
	
if($sql->qo($createstring)){
	$sessie->setS('psa-message','Table created succesfully.');
} else {
	$sessie->setS('psa-error','Table \''.$tablename.'\' could not be created.');
}
/**/
header('location: controller.php?cmd=table');
exit;
/**/
?>