<?php

/**
* [name] autoload.php
* [type] file
* [expl] autoload.php voor psa
* [since] 2010-09-22
*/

function __autoload($class_name)
{
	require_once('./classes/'.$class_name.'.php');
}

if(!file_exists('./data/base.sqlite')) {
	header('location: setup.php');
	exit;
}

define('LIMIT',100);

$psa = new LitePDO('sqlite:./data/base.sqlite');
$q = "SELECT * FROM base";
$psa->qo($q);
$result = $psa->fo_one();
unset($psa);

$sessie = new Session;
date_default_timezone_set('Europe/Paris');
/**
* [comment] Logger directieven
*/
define('LOGGER_DEBUG', 100);
define('LOGGER_INFO', 75);
define('LOGGER_NOTICE', 50);
define('LOGGER_WARNING', 25);
define('LOGGER_ERROR', 10);
define('LOGGER_CRITICAL', 5);

$cfg['LOGGER_FILE'] = 'psa.log';
$cfg['LOGGER_LEVEL'] = LOGGER_DEBUG;
$log = Logger::getInstance();

$req = new Request;

$submit = new Input;
$submit->setName('submit');
$submit->setType('submit');

$cmd = new Input;
$cmd->setName('cmd');
$cmd->setType('hidden');


?>
