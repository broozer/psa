<?php

/**
* [type] file
* [name] drop_idx.php
* [package] psa
* [since] 2012.02.23
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
	
$q = "DROP INDEX ".$req->get('idxname')." ";
$sql->qo($q);
	
$sessie->setS('psa-error','Index "'.$req->get('idxname').'" dropped.');
header('location: index.php?cmd=tableinfo&table='.$req->get('table'));
exit;

?>