<?php

/*
** [type] file
** [name] tableedit.php
** [author] Wim Paulussen
** [since] 2007-09-28
** [update] 2007-09-28 start
** [expl] edit chosen record (with edit and drop)
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
$record_id = $_GET['rowid'];

$sql = new Sqlite3($datadir.'/'.$db_name,$db_type);
$q = "SELECT * FROM ".$table_name." WHERE id = ".$record_id;

foreach ($sql->query($q) as $row)
{

	$rowkeys = array_keys($row);
	
	for($i=0;$i<sizeof($rowkeys);++$i)
	{
		$keys[$i] = $rowkeys[$i];
		$keysval[$i] = $row[$rowkeys[$i]];
	}
}

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

$form = new Form;
$form->setAction('./tableedit_do.php');
$form->build();

$table	= new Table;
$table->build();

$tr = new Tr;
$tr->addElement($hidden_db_name->build());
$tr->addElement($hidden_table_name->build());
$tr->addElement($hidden_db_type->build());
$tr->build();

for($i=0;$i<sizeof($keysval);++$i)
{
	
	$inp = new Input;
	$inp->setName($keys[$i]);
	$inp->setValue($keysval[$i]);
	$inp->setSize(50);
	$inp->setMaxlength(128);
	if($keys[$i] == 'id')
	{
		
		$inp->setType('hidden');
		$tr = new Tr;
		$tr->addElement($inp->build());
		$tr->build();
		
	}
	else
	{
		$tr = new Tr;
		$tr->addElement($keys[$i]);
		$tr->addElement($inp->build());
		$tr->build();
	}
	
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