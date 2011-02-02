<?php

/**
*¨[type] file
* [name] edit_do.php
* [package] psa
* [since] 2010.12.29
* [expl] action file !!
* [expl] todo = binder
*/

// $req->dump();

$sql = new LitePDO('sqlite:'
	.$sessie->getS('psa-dir').'/'
	.$sessie->getS('psa-db').'.'
	.$sessie->getS('psa-ext').'');


$q = "PRAGMA table_info('".$req->get('data_table')."')";
$sql->qo($q);
$res = $sql->fo();

$pk = false;

foreach($res as $item) {
	if($item->name == 'id') {
		$pk = true;
	}
}

$keys = array_keys($_POST);

$j = 0;

for($i=0;$i<sizeof($keys);++$i) {
	if($keys[$i] == 'data_table' 
		|| $keys[$i] == 'data_id' 
		|| $keys[$i] == 'cmd'
		|| $keys[$i] == 'submit'
		) {
		continue;
	}
	$datafields[$j]['field'] = $keys[$i];
	$datafields[$j]['value'] = $req->get($keys[$i]);	
	++$j;

}

$q = "UPDATE ".$req->get('data_table')." SET ";

for($i=0;$i<sizeof($datafields);++$i) {
	$q .= $datafields[$i]['field']." = '".$datafields[$i]['value']."' ,";
}

$q = substr($q,0,-1);

if($pk) {
	$q .= " WHERE id = ".$req->get('data_id')." ";
} else {
	$q .= " WHERE ROWID = ".$req->get('data_id')." ";
}

$sql->qo($q);

$sessie->setS('psa-message','Record updated.');
/**/
header('location: index.php?cmd=edit_record&table='.$req->get('data_table').'&id='.$req->get('data_id'));
exit;
/**/

?>