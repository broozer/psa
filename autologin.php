<?php

/**
 * [type] file
 * [name] autologin.php
 * [package] psa
 * [since] 2012.11.17
 * [expl] autologin
 */


function __autoload($class_name) {
	require_once('./classes/'.$class_name.'.php');
}

if(!file_exists('./data/base.sqlite')) {
	header('location: setup.php');
	exit;
}

$sessie = new Session;
$req = new Request;

if(!$sessie->isS('keren')) {
	$sessie->setS('keren',0);
}

if($sessie->isS('psa-valid')) {
	$sessie->unsetS('psa-valid');
}

define('DSN','sqlite:./data/base.sqlite');

$sql = new LitePDO(DSN);

$submit = new Input;
$submit->setName('submit');
$submit->setType('submit');
$submit->setvalue('Update');

$cmd = new Input;
$cmd->setName('cmd');
$cmd->setType('hidden');


