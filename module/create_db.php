<?php

/**
*¨[type] file
* [name] create_db.php
* [package] psa
* [since] 2010.10.21
* [expl] action file !!
*/

if($req->get('newdb') == '') {
	$sessie->setS('psa-error','Name database cannot be blank.');
} else {	
	$sql = new LitePDO('sqlite:'
		.$sessie->getS('psa-dir').'/'
		.$req->get('newdb').'.'
		.$sessie->getS('psa-ext').'');
	$sessie->setS('psa-message','Database "'.$req->get('newdb').'" created.');
}
header('location: index.php?cmd=base');
exit;

?>