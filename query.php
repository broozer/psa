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
/*
if($sessie->isS('db_current'))
{
	$sessie->unsetS('db_current');
}
*/
$language = new Language('query',$lang);
$text = $language->getText();

if(isset($_GET['db']))
{
	$db_name = $_GET['db'];
	$menu_top = 'menubartable.php';
}
else
{
	$db_name = $sessie->getS('db_current');
	$menu_top = 'menubar.php';
}


if(isset($_GET['table']))
{
	$table_name = $_GET['table'];
}
else
{
	$table_name = '';
}

if(isset($_GET['db_type']))
{
	$db_type = $_GET['type'];
}
else
{
	$db_type = 3;
}

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

include_once($menu_top);

// $body->line('not yet implemented');

$textqs = new Textarea;
$textqs->setRows(5);
$textqs->setCols(80);
$textqs->setName('querystring');

$subber = new Input;
$subber->setName('submit');
$subber->setType('submit');
$subber->setValue($text['execute']);

$db_name_input = new Input;
$db_name_input->setName('db_name');
$db_name_input->setType('hidden');
$db_name_input->setValue($db_name);
//$db_name_input

$db_table_input = new Input;
$db_table_input->setName('table_name');
$db_table_input->setType('hidden');
$db_table_input->setValue($table_name);

$db_type_input = new Input;
$db_type_input->setName('db_type');
$db_type_input->setType('hidden');
$db_type_input->setValue($db_type);
// $db_type_input

$form = new Form;
$form->setAction('query_do.php');
$form->build();

$table = new Table;
$table->build();

$tr = new Tr;
$tr->addElement($text['qs']);
$tr->addElement($textqs->build());
$tr->addElement($db_name_input->build());
$tr->addElement($db_type_input->build());
$tr->addElement($db_table_input->build());

$tr->build();

$tr = new Tr;
$tr->addElement('&nbsp');
$tr->addElement($subber->build());
$tr->build();

$table->close();
$form->close();

$body->line('</div>
<div id="footer"
	
</div>
</div>');


$body->close();
$html->close();

?>