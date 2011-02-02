<?php

/**
*¨[type] file
* [name] drop_db.php
* [package] psa
* [since] 2010.10.21
* [expl] action file !!
*/

/**/
unlink($sessie->getS('psa-dir').'/'
	.$req->get('db').'.'
	.$sessie->getS('psa-ext'));

/*
echo 'in drop';
/**/
$sessie->setS('psa-message','Database "'.$req->get('db').'" dropped.');
header('location: index.php?cmd=base');
exit;
/**/

?>