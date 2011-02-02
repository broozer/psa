<?php

/**
*¨[type] file
* [name] create_db.php
* [package] psa
* [since] 2010.10.21
* [expl] action file !!
*/

$sql = new LitePDO('sqlite:'
	.$sessie->getS('psa-dir').'/'
	.$req->get('newdb').'.'
	.$sessie->getS('psa-ext').'');

header('location: index.php?cmd=base');
exit;

?>