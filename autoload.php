<?php

/**
 * [name] autoload.php
 * [type] file
 * [expl] autoload.php voor psa
 * [since] 2010.09.22
 * [update] 2013.07.28 : LIMIT removed
 */

function __autoload($class_name) {
	require_once('./classes/'.$class_name.'.php');
}

if(!file_exists('./data/base.sqlite')) {
	header('location: setup.php');
	exit;
}

// cookie settings

if(isset($_COOKIE['testcookie'])) {
    $elapsed = $_COOKIE['testcookie'];
    $now = time();
    /*
    echo 'now : '.$now.'<br>';
    echo $now-$elapsed;
    echo '<br>';
    */
    if($now > ($elapsed+300)) {
        setcookie('testcookie','gone',time()-3600);
        header('location: login.php');
        exit;
    } else {
        setcookie( 'testcookie', time(), time()+600);
    }
    
} else {
    setcookie('testcookie','gone',time()-3600);
    header('location: login.php');
    exit;
}

$sessie = new Session;

$valgeld = $sessie->getS('psa-valid');

if($valgeld !== 'jaja') {
	header('location: login.php');
	exit;
}

$psa = new LitePDO('sqlite:./data/base.sqlite');
$q = "SELECT * FROM base";
$psa->qo($q);
$result = $psa->fo_one();

if(!$sessie->isS('psa-ext')) {
    $sessie->setS('psa-ext',$result->extension);
}

if(!$sessie->isS('psa-dir')) {
    $sessie->setS('psa-dir',$result->directory);
}
	
define('LIMIT',$result->nr_rows);

unset($psa);

$req = new Request;

$submit = new Input;
$submit->setName('submit');
$submit->setType('submit');

$cmd = new Input;
$cmd->setName('cmd');
$cmd->setType('hidden');

