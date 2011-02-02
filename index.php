<?php

/**
*¨[type] file
* [name] index.php
* [package] psa
* [since] 2010.09.22
*/

include_once('autoload.php');

if($req->is('cmd') && $req->get('cmd') !== 'nodatabase')
{
	// clear bottom -> paging in table_browse
	if($req->get('cmd') !== 'table_browse' && $sessie->isS('bottom')) {
		$sessie->unsetS('bottom');
	}
	if(!file_exists('./module/'.$req->get('cmd').'.php')) {
		$sessie->setS('psa-error','Module <b>"'.$req->get('cmd').'"</b> does not exists (yet) !');
		header('location: index.php');
		exit;
	} else {
		include_once('./module/'.$req->get('cmd').'.php');
	}
	
}
else
{
	$sessie->unsetS('psa-dir');
	$sessie->unsetS('psa-ext');
	$sessie->unsetS('psa-db');
	
	$cmd->setValue('base');
	$submit->setValue('Go!');
	
	include_once('./inputs/inp_base.php');
	
	$html = new Html;
	$html->setDoctype('xhtml-strict');
	$html->setLanguage('nl_NL');
	$html->build();
	
	$head = new Head;
	$head->setCharset('UTF-8');
	$head->setTitle('PSA - homepage');
	$head->setCss('./css/psa.css');
	$head->build();
	
	$body = new Body;
	$body->build();

	$body->line('<div id="header">PSA - homepage</div>');
	if($sessie->isS('psa-error')) {
		$body->line('<div id="error">'.$sessie->getS('psa-error').'</div>');
		$sessie->unsetS('psa-error');
	}
	
	$body->line('<div id="content">');

	$body->line('
	<p>Databases will be selected based on the preset directory and extension. 
	Currently the following are stored : </p>');
	include_once('./forms/form_base.php');
	$body->line('
	<p>PSA stands for PHP - SQLite - Administration. This application lets you 
	do the basic operations with SQLite<b>3</b> databases. The current version only
	supports the very basics. The following issues are already implemented :
	<ul>
		<li>select directory and extension</li>
		<li>list databases based on the above</li>
		<li>list tables based on selected database</li>
		<li>perform random queries on the selected database</li>
		<li>show table structure</li>
		<li>browse table</li>
		<li>create database</li>
		<li>drop database</li>
		<li>vacuum database</li>
	</ul>
	<ul>Roadmap :
		<li>create table</li> 
		<li>drop table</li>
		<li>insert rows</li>
		<li>update rows</li>
		<li>delete rows</li>
		<li>list indexes</li>
		<li>create indexes</li>
		<li>drop indexes</li>
	</ul>
	<ul>Not yet planned :
		<li>stored procedures</li>
		<li>triggers</li>
	</ul></p>');
	

	$body->line('</div>');
	unset($body);
	unset($html);
}

?>