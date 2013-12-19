<?php

/*
 * [file] login.php
 * [since] 2013.04.06
 * [wings_ok]
 */

include_once('./autologin.php');

if($sessie->isS('psa-valid')) {
	$sessie->unsetS('psa-valid');
}

/**/
if(!$sessie->isS('keren')) {
	$sessie->setS('keren',0);
} else {
	if($sessie->getS('keren') > 3) {
		die('nogo');
	}
}

if($req->is('geheim')) {
	$q = "SELECT user FROM base WHERE user ='".$req->get('name')."' and pass = '".md5($req->get('geheim'))."' ";	
	// admin - asp
	$sql->qo($q);
	$res = $sql->fo_one();
	
	if(!$res) {
		$keren = $sessie->getS('keren')+1;
		$sessie->setS('keren',$keren);
	} else {

		// echo 'haai';
		$sessie->setS('psa-valid','jaja');
		/**/
		setcookie( 'testcookie', time(), time()+300);
		header('location: controller.php');
		exit;
		/**/
	}

}
$submit->setValue('Let\'s go');

$inp_naam = new Input;
$inp_naam->setName('name');
$inp_naam->setSize(20);
$inp_naam->setAutofocus(true);

$inp_pass = new Input;
$inp_pass->setName('geheim');
$inp_pass->setType('password');
$inp_pass->setSize(20);


$html = new Page;
$html->setLanguage('nl-nl');
$html->build();

$head = new Head;
$head->setTitle('PSA - login');
$head->setCss('./css/psa.css');
$head->setJs('./js/PSA.js');
$head->build();

$body = new Body;
$body->build();

$body->line('<h3>PHP SQLite Admin tool - log in</h3>');
$form = new Form;
$form->setAction('login.php');
$form->build();

$table = new Table;
$table->build();

$tr = new Tr;
$tr->add('Login');
$tr->add($inp_naam->dump());
$tr->build();

$tr = new Tr;
$tr->add('Pass');
$tr->add($inp_pass->dump());
$tr->build();

$tr = new Tr;
$tr->add('&nbsp;');
$tr->add($submit->dump());
$tr->build();


unset($table);
unset($form);
