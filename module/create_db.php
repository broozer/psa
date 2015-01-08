<?php

/**
*¨[type] file
* [name] create_db.php
* [package] psa
* [since] 2010.10.21
* [update] 2015.01.08 - check dir writable
* [expl] creates database (file) if directory is writable 
/

if($req->get('newdb') == '') {
	$sessie->setS('psa-error','Name database cannot be blank.');
} else {
        // check if directory is writable
        if(!is_writable($sessie->getS('psa-dir'))) {
            $sessie->setS('psa-error',"Directory is not writeable, database cannot be created.");
        } else {    
	    $sql = new LitePDO('sqlite:'
		.$sessie->getS('psa-dir').'/'
		.$req->get('newdb').'.'
		.$sessie->getS('psa-ext').'');
	    $sessie->setS('psa-message','Database "'.$req->get('newdb').'" created.');
        }        
}
header('location: controller.php?cmd=base');
exit;
