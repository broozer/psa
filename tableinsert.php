<?php

/*
** [type] file
** [name] tableinsert.php
** [author] Wim Paulussen
** [since] 2007-08-24
** [update] 2007-08-24 start
** [expl] browse table (with edit and drop)
** [end]
*/

include_once('./autoload.php');

// NOTE: op de homepage is geen enkele databank geselecteerd
if($sessie->isS('db_current'))
{
	$sessie->unsetS('db_current');
}

$db_name = $_GET['db'];
$table_name = $_GET['table'];
$db_type = $_GET['type'];

$language = new Language('tableinsert',$lang);
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

include_once('menuleft.php');

$body->line('
<div id="content">');

include_once('menubartable.php');

if ($sql = new Sqlite3($datadir.'/'.$db_name,$db_type))
{
	$q	= "PRAGMA table_info(".$table_name.")";
	$i = 0;
	
	foreach ($sql->query($q) as $row)
	{
		if($row['pk'] == '1')
		{
			continue;
		}
		else
		{
			$field[$i]	= $row['name'];
			$type_length = $row['type'];
			$pos = strpos($type_length,'(');
			if($pos == 0)
			{
				$fieldtype[$i] = $type_length;
			}
			else
			{
				$fieldtype[$i] = substr($type_length,0,$pos);
			}
			++$i;
		}
	}
	
}


$table	= new Table;
$table->build();

for($i=0;$i<sizeof($field);++$i)
{
	if($fieldtype[$i] == 'TEXT')
	{
		$inp = new Textarea;
		$inp->setRows(3);
		$inp->setCols(60);
		$inp->setName($field[$i]);
	}
	else
	{
		$inp = new Input;
		$inp->setName($field[$i]);
		$inp->setSize(50);
		$inp->setMaxlength(128);
	}
	
	$tr = new Tr;
	$tr->addElement($field[$i]);
	$tr->addElement($inp->build());
	$tr->build();
}

$sub	= new Input;
$sub->setName('submit');
$sub->setType('submit');
$sub->setValue($text['submit']);

$tr = new Tr;
$tr->addElement('&nbsp');
$tr->addElement($sub->build());
$tr->build();

$table->close();;

$body->line('</div>
<div id="footer"
	
</div>
</div>');


$body->close();
$html->close();

?>