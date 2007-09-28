<?php

/*
** [type] file
** [name] index.php
** [author] Wim Paulussen
** [since] 2007-05-21
** [update] 2007-08-22 : redo initial layout
** [expl] startfile for psa (PHP-Sqlite-Admin)
** [end]
*/

include_once('./autoload.php');

// NOTE: no databases selected on homepage
if($sessie->isS('db_current'))
{
	$sessie->unsetS('db_current');
}
$language = new Language('index',$lang);
$text = $language->getText();

$newdb	= new Input;
$newdb->setName('database');
$newdb->setSize('25');
$newdb->setMaxlength('128');

$submit	= new Input;
$submit->setName('submit');
$submit->setType('submit');
$submit->setSize('25');
$submit->setValue($text['submit']);

try
{
	$html	= new Html;
	$html->setDoctype('xhtml-strict');
	$html->setLanguage('en');
	$html->build();
	
	$head	= new Head;
	$head->setTitle($text['title']);
	$head->setCss('./css/psa.css');
	$head->build();
	
	$body	= new Body;
	$body->build();
	
	$body->line('
	<div class="page">
	<div id="header">');
	include_once('./top.php');
	$body->line('</div>');
	
	include_once('./top.php');
	include_once('menuleft.php');
	
	$body->line('
	<div id="content">'.$text['content'].'<hr />');
	
	$form	= new Form;
	$form->setAction('createdb.php');
	$form->build();
	
	$table	= new Table;
	$table->build();
	
	$tr	= new Tr;
	$tr->addElement($text['dbase']);
	$tr->setClas('nieuw');
	$tr->setId('oud');
	$tr->addElement($newdb->build());
	$tr->addElement($submit->build());
	$tr->build();
	
	$table->close();
	$form->close();
	
	$body->line('</div>
	<div id="footer">
	</div>
	</div>');
	
	
	$body->close();
	$html->close();
}
catch(InputException $e) { echo $e->getMessage(); }
catch(HeadException $e) { echo $e->getMessage(); }
catch(HTMLException $e) { echo $e->getMessage(); }
catch(Exception $e)
{
	echo "Fatal <br />";
	echo "<blockqoute>".$e->getMessage()." [".$e->getCode()."]</blockquote>";
}
?>
