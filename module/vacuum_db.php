<?php

/**
 * [type] file
 * [name] vacuum_db.php
 * [package] psa
 * [since] 2010.10.21
 * [expl] action file
 */

$sql = new LitePDO('sqlite:'
	.$sessie->getS('psa-dir').'/'
	.$req->get('db').'.'
	.$sessie->getS('psa-ext').'');

$sql->qo('VACUUM');

$sessie->setS('psa-message','Vacuum performed on "'.$req->get('db').'".');
header('location: controller.php?cmd=base');
exit;