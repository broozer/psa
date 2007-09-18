<?php

/*
** [type] file
** [name] tabledisplay.php
** [author] Wim Paulussen
** [since] 2007-06-05
** [update] 2007-08-22 update layout
** [expl] display table info ( structure - size - indexes)
** [end]
*/

include_once('./autoload.php');

// NOTE: op de homepage is geen enkele databank geselecteerd
if($sessie->isS('db_current'))
{
	$sessie->unsetS('db_current');
}
$language = new Language('tabledisplay',$lang);
$text = $language->getText();

$db_name = $_GET['db'];
$table_name = $_GET['table'];
$db_type = $_GET['type'];

$language = new Language('tabledisplay',$lang);
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

// DEBUG: include menuleft.php
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
		$field[$i]['name']	= $row['name'];
		$type_length = $row['type'];
		$pos = strpos($type_length,'(');
		if($pos == 0)
		{
			$field[$i]['type'] = $type_length;
			$field[$i]['length'] = '-';
		}
		else
		{
			$field[$i]['type'] = substr($type_length,0,$pos);
			$field[$i]['length'] = substr($type_length,$pos+1,-1);
		}
		if($row['notnull'] == '0')
		{
			$field[$i]['null']	= 'NULL';
		}
		else
		{
			$field[$i]['null']	= 'NOT NULL';
		}
		if ($row['dflt_value'] == NULL)
		{
			$field[$i]['dflt']	= '-';
		}
		else
		{
			$field[$i]['dflt']	= $row['dflt_value'];
		}
		
		$field[$i]['pk']		= $row['pk'];
		++$i;
	}
}

$table	= new Table;
$table->build();

$th = new Th;
$th->addElement($text['column_name']);
$th->addElement($text['col_type']);
$th->addElement($text['col_length']);
$th->addElement($text['col_null']);
$th->addElement($text['col_default']);
$th->addElement($text['col_primary']);

$th->build();

for($i=0;$i<sizeof($field);++$i)
{
	$tr	= new Tr;
	$tr->addElement($field[$i]['name']);
	$tr->addElement($field[$i]['type']);
	$tr->setClas('centraal');
	$tr->addElement($field[$i]['length']);
	$tr->addElement($field[$i]['null']);
	$tr->setClas('centraal');
	$tr->addElement($field[$i]['dflt']);
	$tr->setClas('centraal');
	$tr->addElement($field[$i]['pk']);
	$tr->build();
}

$table->close();;

$q	= "SELECT * FROM sqlite_master WHERE tbl_name = '".$table_name."' ";
foreach ($sql->query($q) as $row)
{
	$sqlstat  = $row['sql'];
}

echo '<hr />'.$sqlstat;

$body->line('</div>
<div id="footer"
	
</div>
</div>');


$body->close();
$html->close();

?>