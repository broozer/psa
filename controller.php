<?php

/**
 * type] file
 * [name] controller.php
 * [package] psa
 * [since] 2010.09.22
 */

include_once('autoload.php');

if($sessie->isS('psa-first')) {
    
}
if($req->is('cmd') && $req->get('cmd') !== 'nodatabase') {
	/* prevents direct linking after controller.php has run */
	if(!$sessie->isS('psa-dir') && $req->get('cmd') !== 'base' && $req->get('cmd') !== 'bts') {
		header('location: controller.php');
		exit;
	}
	
	if(!file_exists('./module/'.$req->get('cmd').'.php')) {
		$sessie->setS('psa-error','Module <b>"'.$req->get('cmd').'"</b> does not exists (yet) !');
		header('location: controller.php');
		exit;
	} else {
		include_once('./module/'.$req->get('cmd').'.php');
	}
	
} else {
	
	$sessie->unsetS('psa-dir');
	$sessie->unsetS('psa-ext');
	$sessie->unsetS('psa-db');
	
	$cmd->setValue('base');
	$submit->setValue('Go');
	
	$html = new Page;
	$html->setLanguage('nl_NL');
	$html->build();
	
	$head = new Head;
	$head->setTitle('PSA - homepage');
	$head->setCss('./css/psa.css');
	$head->setJs('./js/PSA.js');
	$head->build();
	
	$body = new Body;
	$body->build();

	include_once('./inc/menubar.php');

	$body->line('
	<p>Databases will be selected based on the preset directory and extension.
	Currently the following are stored : </p>');
	
	include_once('./forms/form_base.php');
	
	$body->line('<hr />
	<p>PSA stands for PHP - SQLite - Administration. This application lets you
	do the basic operations with SQLite3 databases. The current version only
	supports the very basics. Check <a href="controller.php?cmd=bts">[here]</a> for
	more information.</p>
	<p>	The following issues are already implemented :</p>
	<ul>
		<li>select directory and extension</li>
		<li>list databases based on the above</li>
		<li>list tables based on selected database</li>
		<li>perform random queries on the selected database</li>
		<li>show table structure</li>
		<li>browse table</li>
		<li>update rows</li>
		<li>delete rows</li>
		<li>create database</li>
		<li>drop database</li>
		<li>vacuum database</li>
		<li>create table</li>
		<li>drop column</li>
		<li>dump sql statements per table</li>
		<li>insert rows</li>
		<li>drop table</li>
		<li>list indexes (part of table info)</li>
		<li>drop indexes</li>
		<li>create indexes</li>
		<li>list views</li>
		<li>drop views</li>
	</ul>
	<p>Roadmap :</p>
	<ul>
		<li>dump database structure</li>
		<li>dump table data to csv et al</li>
		<li>show all performed queries and also hold result</li>
	</ul>
	<p>Not yet planned :</p>
	<ul>
		<li>stored procedures</li>
		<li>triggers</li>
	</ul>');
	

	$body->line('</div>');
	include_once('./inc/footer.php');
}
