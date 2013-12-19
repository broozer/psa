<?php

/**
* [type] file
* [name] drop_table.php
* [package] psa
* [since] 2012.02.12
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
	
$q = "DROP TABLE ".$req->get('table')." ";
$sql->qo($q);
	
$sessie->setS('psa-error','Table "'.$req->get('table').'" dropped.');
header('location: controller.php?cmd=table');
exit;

?>