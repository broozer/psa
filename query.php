<?php

/*
** [type] file
** [name] query.php
** [author] Wim Paulussen
** [since] 2007-08-24
** [update] 2007-08-24 for namesake
** [expl] issue queries
** [end]
*/

include_once('./autoload.php');

// NOTE: op de homepage is geen enkele databank geselecteerd
if($sessie->isS('db_current'))
{
	$sessie->unsetS('db_current');
}
$language = new Language('query',$lang);
$text = $language->getText();

$db_name = $_GET['db'];
$table_name = $_GET['table'];
$db_type = $_GET['type'];

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

$body->line('not yet implemented');
$body->line('</div>
<div id="footer"
	
</div>
</div>');


$body->close();
$html->close();

?>