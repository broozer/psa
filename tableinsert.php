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

$hidden_db_name = new Input;
$hidden_db_name->setName('db');
$hidden_db_name->setType('hidden');
$hidden_db_name->setValue($db_name);

$hidden_table_name = new Input;
$hidden_table_name->setName('table');
$hidden_table_name->setType('hidden');
$hidden_table_name->setValue($table_name);

$hidden_db_type = new Input;
$hidden_db_type->setName('db_type');
$hidden_db_type->setType('hidden');
$hidden_db_type->setValue($db_type);

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

$form = new Form;
$form->setAction('./tableinsert_do.php');
$form->build();

$table	= new Table;
$table->build();

$tr = new Tr;
$tr->addElement($hidden_db_name->build());
$tr->addElement($hidden_table_name->build());
$tr->addElement($hidden_db_type->build());
$tr->build();

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
$form->close();

$body->line('</div>
<div id="footer"
	
</div>
</div>');


$body->close();
$html->close();
}
catch(InputException $e) { echo $e->getMessage(); }
catch(FormException $e) { echo $e->getMessage(); }
catch(HeadException $e) { echo $e->getMessage(); }
catch(HTMLException $e) { echo $e->getMessage(); }
catch(Exception $e)
{
	echo "Fatal <br />";
	echo "<blockqoute>".$e->getMessage()." [".$e->getCode()."]</blockquote>";
}
?>