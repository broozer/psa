<?php

/**
*¨[type] file
* [name] base.php
* [package] psa
* [since] 2010.09.22
*/

if(!$sessie->isS('psa-ext')) {
	if($req->get('extension') == '') {
		$sessie->setS('psa-error','Extension name cannot be blank.');
		header('location: index.php');
		exit;
	}
	
	if($req->get('directory') == '') {
		$req->set('directory','.');
	} else {
		if(!is_dir($req->get('directory'))) {
			$sessie->setS('psa-error','Directory does not exist.');
			header('location: index.php');
			exit;
		}
	}	
}

if($req->is('extension')) {
	$sessie->setS('psa-dir',$req->get('directory'));
	$sessie->setS('psa-ext',$req->get('extension'));
	
	$psa = new LitePDO('sqlite:./data/base.sqlite');
	$q = "UPDATE base SET directory = :directory, extension = :extension";
	$psa->binder('directory',$req->get('directory'));
	$psa->binder('extension',$req->get('extension'));
	$psa->qo($q);
	unset($psa);
}

if($sessie->isS('psa-db')) {
	$sessie->unsetS('psa-db');
}

$html = new Html;
$html->setDoctype('xhtml-strict');
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
$form->setAction('index.php');
$form->build();

$table = new Table;
$table->build();

$tr = new Tr;
$tr->addElement('New database : ');
$tr->addElement($inp_db->dump());
$tr->addElement($submit->dump());
$tr->addElement($cmd->dump());
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
		$link->setHref('index.php?cmd=table&amp;db='.urlencode($files[$i]));
		$link->setName('['.$files[$i].']');

		$vacuum = new Link;
		$vacuum->setHref('index.php?cmd=vacuum_db&amp;db='.urlencode($files[$i]));
		$vacuum->setName('[vacuum]');
		
		$drop = new Link;
		$drop->setHref('index.php?cmd=drop_db&amp;db='.urlencode($files[$i]));
		$drop->setName('[drop]');
		$drop->setJs(' onclick="return PSA.really_drop(\'database\');" ');
		
		$tr = new Tr;
		if($odd) {
			$tr->setGlobalClass('even');
			$odd = FALSE;
		} else {
			$tr->setGlobalClass('odd');
			$odd = TRUE;
		}
		$tr->addElement($link->dump());
		$tr->addElement($vacuum->dump());
		$tr->addElement($drop->dump());
		$tr->build();
		
	} 

	unset($table);
}

$body->line('<hr />');

$body->line('</div>');
unset($body);
unset($html);


?>