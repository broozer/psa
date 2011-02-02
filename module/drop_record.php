<?php

/**
*¨[type] file
* [name] drop_record.php
* [package] psa
* [since] 2010.11.13
* [expl] action file !!
*/

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
}

if($pk) {
	$q = "DELETE FROM ".$req->get('table')." WHERE id = ".$req->get('id');
} else {
	$q = "DELETE FROM ".$req->get('table')." WHERE ROWID = ".$req->get('id');
}

$sql->qo($q);

/**/
header('location: index.php?cmd=table_browse&table='.$req->get('table'));
exit;
/**/

?>