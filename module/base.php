<?php

/**
 * [type] file
 * [name] base.php
 * [package] psa
 * [since] 2010.09.22
 * [update] 2015.01.10 - is_writable check on directory
 */


if(!$sessie->isS('psa-ext')) {
    if($req->get('extension') == '') {
        $sessie->setS('psa-error','Extension name cannot be blank.');
	header('location: controller.php');
	exit;
    }
	
    if($req->get('directory') == '') {
    	$req->set('directory','.');
    } else {
	if(!is_dir($req->get('directory'))) {
    	    $sessie->setS('psa-error','Directory does not exist.');
	    header('location: controller.php');
	    exit;
        }

        // check if directory is writable
        if(!is_writable($req->get('directory'))) {
            $sessie->setS('psa-error',"Directory not writable.");
            header("location: controller.php?cmd=base");
            exit;
            }
    }
}

if($req->is('extension')) {
	$sessie->setS('psa-dir',$req->get('directory'));
	$sessie->setS('psa-ext',$req->get('extension'));
	
	$psa = new LitePDO('sqlite:./data/base.sqlite');
	
	$q = "UPDATE
		base
	SET
		directory = :directory
		, extension = :extension
		, nr_rows = :nr_rows
	";
	
	$psa->binder('directory',$req->get('directory'));
	$psa->binder('extension',$req->get('extension'));
	$psa->binder('nr_rows',$req->get('nr_rows'));
	$psa->qo($q);
	unset($psa);
}

if($sessie->isS('psa-db')) {
	$sessie->unsetS('psa-db');
}

if(!is_writable($sessie->getS('psa-dir'))) {
    $sessie->setS('psa-error',"Directory not writable.");
    header("location: controller.php");
    exit;
}

$html = new Page;
 
$html->setLanguage('nl_NL');
$html->build();

$head = new Head;
$head->setCharset('UTF-8');
$head->setTitle('PSA - connection');
$head->setCss('./css/psa.css');
$head->setJs('./js/PSA.js');
$head->build();

$body = new Body;
$body->build();

include_once('./inc/menubar.php');

$inp_db = new Input;
$inp_db->setName('newdb');
$inp_db->setSize(25);
$inp_db->setMaxlength(128);

$submit->setValue('Create');
$submit->setClas('button');
$cmd->setValue('create_db');

$form = new Form;
$form->setAction('controller.php');
$form->build();

$table = new Table;
$table->build();

$tr = new Tr;
$tr->add('New database : ');
$tr->add($inp_db->dump());
$tr->add($submit->dump());
$tr->add($cmd->dump());
$tr->build();

unset($table);
unset($form);

$body->line('<hr />');

$files = Array();


if ($handle = opendir($sessie->getS('psa-dir')) ) {
    while (false !== ($file = readdir($handle))) {
        if ($file != "." && $file != "..") {
            if(stristr($file,'.'.$sessie->getS('psa-ext'))) {
            	$files[] = str_replace('.'.$sessie->getS('psa-ext'),'',$file);
            }
        }
    }
    closedir($handle);
    if('0' !== sizeof($files)) {
    	sort($files);
    }
}

$odd = TRUE;

if(!$files) {
	$body->line('<p>No databases found in the given directory with the given extension.</p>');
} else {
	$table = new Table;
	$table->setId('listing');
	$table->build();

	for($i=0;$i<sizeof($files);++$i) {
		$link = new Link;
		$link->setHref('controller.php?cmd=table&amp;db='.urlencode($files[$i]));
		$link->setName('['.$files[$i].']');

		$vacuum = new Link;
		$vacuum->setHref('controller.php?cmd=vacuum_db&amp;db='.urlencode($files[$i]));
		$vacuum->setName('[vacuum]');
		
		$drop = new Link;
		$drop->setHref('controller.php?cmd=drop_db&amp;db='.urlencode($files[$i]));
		$drop->setName('[drop]');
		$drop->setJs(' onclick="return PSA.really_drop(\'database\');" ');

		$schema = new Link;
		$schema->setHref('controller.php?cmd=schema_db&amp;db='.urlencode($files[$i]));
		$schema->setName('[schema]');
		
		$tr = new Tr;
		if($odd) {
			$tr->setGlobalClass('even');
			$odd = FALSE;
		} else {
			$tr->setGlobalClass('odd');
			$odd = TRUE;
		}
		$tr->add($link->dump());
		$tr->add($vacuum->dump());
		$tr->add($drop->dump());
		$tr->add($schema->dump());
		$tr->build();
		
	}

	unset($table);
}

$body->line('</div>');
include_once('./inc/footer.php');
unset($body);
unset($html);


?>
