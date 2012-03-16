<?php

/**
* [type] file
* [name] drop_view.php
* [package] psa
* [since] 2012.03.15
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
	
$q = "DROP VIEW ".$req->get('table')." ";
$sql->qo($q);
	
$sessie->setS('psa-error','Table "'.$req->get('table').'" dropped.');
header('location: index.php?cmd=table');
exit;

?>