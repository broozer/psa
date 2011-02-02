<?php

/**
*¨[type] file
* [name] qs.php
* [package] psa
* [since] 2010.09.22 - o
*/

if(trim($req->get('qs')) == '') {
	$sessie->setS('psa-error','Query cannot be blank.');
	header('location: index.php?cmd=query');
	exit;
}


try {
   $psa = new PDO('sqlite:./data/base.sqlite');
} catch (PDOException $e) {
    echo 'Connection failed: ' . $e->getMessage();
}
$qar = stripslashes($req->get('qs'));
/**/

$q = "INSERT INTO queries (qs,datum,db) VALUES (:qs,:datum,:db)";
$tps = $psa->prepare($q);

$datum = date('Y-m-d H:i:s');
$db = $sessie->getS('psa-db');
try {
	$tps->bindparam(':qs',$qar);
	$tps->bindparam(':datum',$datum);
	$tps->bindparam(':db',$db);
	$tps->execute();
} catch (PDOException $e) {
    echo 'Connection failed: ' . $e->getMessage();
}
/**/
unset($psa);

// QUERY
$sql = new LitePDO('sqlite:'
	.$sessie->getS('psa-dir').'/'
	.$sessie->getS('psa-db').'.'
	.$sessie->getS('psa-ext').'');
$q = stripslashes($req->get('qs'));

$sql->qo($q);
$res = $sql->fo();

if(!$res) {

	/**/
	header('location: index.php?cmd=query');
	exit;
	/**/
} else {
	$sessie->setS('psa-results',serialize($res));
	$sessie->setS('psa-query-results',$q);
	header('location: index.php?cmd=query_results');
	exit;
}
?>