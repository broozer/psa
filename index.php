<?php

/**
*�[type] file
* [name] index.php
* [package] psa
* [since] 2010.09.22
*/

include_once('autoload.php');

if($req->is('cmd') && $req->get('cmd') !== 'nodatabase')
{
	/* prevents direct linking after index.php has run */
	if(!$sessie->isS('psa-dir') && $req->get('cmd') !== 'base' && $req->get('cmd') !== 'bts') {
		header('location: index.php');
		exit;
	}
	
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
	supports the very basics. Check <a href="index.php?cmd=bts">[here]</a> for
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
	</ul>
	<p>Roadmap :</p>
	<ul>
		<li>CRUD views</li>
		<li>dump database structure</li>
		<li>dump table data to csv et al</li>
	</ul>
	<p>Not yet planned :</p>
	<ul>
		<li>stored procedures</li>
		<li>triggers</li>
	</ul>');
	

	$body->line('</div>');
	include_once('./inc/footer.php');
	unset($body);
	unset($html);
}

?>