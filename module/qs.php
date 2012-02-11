<?php

/**
* [type] file
* [name] qs.php
* [package] psa
* [since] 2010.09.22 - o
* [update] 2011.03.07 : mulitple query statements divided by ;
*/

set_time_limit('600');

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

$q_ar = explode(";",$q);

$error = FALSE;

for($i=0;$i<sizeof($q_ar);++$i) {
	if(trim($q_ar[$i]) === '') {
		continue;
	}
	
	if(!$sql->qo($q_ar[$i])) {
		$error = TRUE;
		break;
	} else {
		$res = $sql->fo();
		/* */
	}
	
	if(stristr($q_ar[$i],"NSERT INTO")) {
		// void
	} else {
		if(!$res) {
			$error = TRUE;
			break;
		}
	}
}

if($error) {
	header('location: index.php?cmd=query');
	exit;
} else {
	$sessie->setS('psa-results',serialize($res));
	$sessie->setS('psa-query-results',$q);
	header('location: index.php?cmd=query_results');
	exit;
}

?>