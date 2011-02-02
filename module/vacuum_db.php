<?php

/**
*¨[type] file
* [name] vacuum_db.php
* [package] psa
* [since] 2010.10.21
* [expl] action file !!
*/

/*
$size_before = filesize($sessie->getS('psa-dir').'/'
	.$req->get('db').'.'
	.$sessie->getS('psa-ext'));
*/
$sql = new LitePDO('sqlite:'
	.$sessie->getS('psa-dir').'/'
	.$req->get('db').'.'
	.$sessie->getS('psa-ext').'');

$sql->qo('VACUUM');

/*
$size_after = filesize($sessie->getS('psa-dir').'/'
	.$req->get('db').'.'
	.$sessie->getS('psa-ext'));
*/

$sessie->setS('psa-message','Vacuum performed on "'.$req->get('db').'".');
header('location: index.php?cmd=base');
exit;
/**/

?>