<?php

/*
** [type] file
** [name] tablebrowse.php
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
		$field[$i]	= $row['name'];
		++$i;
	}
	
	/*
	$q = "INSERT INTO tester (name,adres,pn) VALUES ('wim','hm 49','2110')";
	$sql->query($q);
	$q = "DELETE FROM email WHERE ROWID = 4";
	$sql->query($q);
	*/
}


$table	= new Table;
$table->build();

$th = new Th;
$th->addElement('ROWID');
for($i=0;$i<sizeof($field);++$i)
{
	$th->addElement($field[$i]);
}

$th->build();

$q	= "SELECT ROWID,* FROM ".$table_name;
foreach ($sql->query($q) as $row)
{
	$tr = new Tr;
	if(isset($row['rowid']))
	{
		$tr->addElement($row['rowid']);
	}
	else
	{
		$tr->addElement($row['id']);
	}
	for($i=0;$i<sizeof($field);++$i)
	{
		$tr->addElement($row[$field[$i]]);	
	}
	$tr->build();
}

$table->close();;

$body->line('</div>
<div id="footer"
	
</div>
</div>');


$body->close();
$html->close();

?>