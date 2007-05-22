<?php

/*
** [type] file
** [name]  tables.php
** [author] Wim Paulussen
** [since] 2007-04-13
** [update] 2007-04-13 - start
** [expl] 
** [end]
*/

include_once('./autoload.php');

$db_name = $_GET['name'];
$db_type = $_GET['type'];

$language = new Language('tables',$lang);
$text = $language->getText();

if($sessie->getS('db_current') != $db_name)
{
	$sessie->setS('db_current',$db_name);
	if($sessie->isS('tbls'))
	{
		$sessie->unsetS('tbls');
	}
}

if(!$sessie->isS('tbls'))
{
	if ($sql = new Sqlite3($datadir.'/'.$db_name,$db_type))
	{
		$q	= "SELECT * FROM sqlite_master";
		$i = 0;
		$tbls = array();
		foreach ($sql->query($q) as $row)
		{
			if ($row['type'] == 'table')
			{
				$tbls[$i]['name'] = $row['name'];
				++$i;
			}
		}
		if(sizeof($tbls) != '0')
		{
			$sessie->setS('tbls',$tbls);
		}
	}
}

// var_dump($text);

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
<div id="header">
		<!-- <p class="centraal">'.$text['header'].'<p> -->
</div>');

// DEBUG: include menuleft.php
include_once('menuleft.php');

$body->line('
<div id="content">');

include_once('menubar.php');
// lijst met tabellen

$newdb	= new Input;
$newdb->setName('database');
$newdb->setSize('25');
$newdb->setValue($_GET['name']);
$newdb->setType('hidden');

$newdb_type	= new Input;
$newdb_type->setName('db_type');
$newdb_type->setSize('2');
$newdb_type->setValue($_GET['type']);
$newdb_type->setType('hidden');

$newtable	= new Input;
$newtable->setName('table');
$newtable->setSize('25');

$fields	= new Input;
$fields->setName('fields');
$fields->setSize('3');

$submit	= new Input;
$submit->setName('submit');
$submit->setType('submit');
$submit->setSize('25');
$submit->setValue($text['addtbl']);

$form	= new Form;
$form->setAction('createtable.php');
$form->build();

$table	= new Table;
$table->build();

$tr = new Tr;
$tr->addElement($newdb->build());
$tr->addElement($newdb_type->build());
$tr->build();

$tr	= new Tr;
$tr->addElement($text['adder']);
$tr->addElement($newtable->build());
$tr->build();

$tr = new Tr;
$tr->addElement($text['addcols']);
$tr->addElement($fields->build());
$tr->build();

$tr = new Tr;
$tr->addElement(' ');
$tr->addElement($submit->build());
$tr->build();

$table->close();
$form->close();

$body->line('
</div>
<div id="footer">
	<p class="rechts">&copy; 
		<a href="http://www.asgc.be">
			www.asgc.be
		</a>
	</p>
</div>
</div>');

$body->close();
$html->close();
?>