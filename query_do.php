<?php

include_once('autoload.php');

$language = new Language('query_do',$lang);
$text = $language->getText();

// var_dump($_POST);

$db_name = $_POST['db_name'];
$table_name = $_POST['table_name'];
$db_type = $_POST['db_type'];

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
$q = $_POST['querystring'];

$body->line('Requested query : '.$q.'<hr />');

if ($sql = new Sqlite3($datadir.'/'.$db_name,$db_type))
{
	$table	= new Table;
	$table->build();
	
	foreach ($sql->query($q) as $row)
	{
		for($i=0;$i<sizeof($row);++$i)
		{
			$j = array_keys($row);
		}
		// var_dump($j);
		// var_dump($row);
		
		$tr= new Tr;
		for($i=0;$i<sizeof($row);++$i)
		{
			$k = $j[$i];
			$tr->addElement($row[$k]);
		}
		$tr->build();
		
		// echo '<hr />';
	}

	$table->close();
}


?>
