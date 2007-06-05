<?php

/*
** [type] file
** [name] tabledisplay.php
** [author] Wim Paulussen
** [since] 2007-06-05
** [update] 2007-06-05 = start
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

echo $table_name;

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
<div id="header">
		<!-- <p class="centraal">'.$text['header'].'<p> -->
</div>');

// DEBUG: include menuleft.php
include_once('menuleft.php');

$body->line('
<div id="content">');

include_once('menubartable.php');

$body->line('</div>
<div id="footer"
	<p class="rechts">&copy; 
		<a href="http://www.asgc.be">
			www.asgc.be
		</a>
	</p>
</div>
</div>');


$body->close();
$html->close();

/*
$table_name	= $_GET['table'];
$db_name	= $_GET['db'];

$sql	= new clsSqlite;
$db = $sql->conn($dir."/".$db_name);
$q	= "SELECT * FROM sqlite_master WHERE tbl_name = '".$table_name."' ";
$rq	= $sql->query($db,$q);
$row	= $sql->fetch($rq);
$sqlstat  = $row['sql'];

$q	= "PRAGMA table_info(".$table_name.")";
$rq	= $sql->query($db,$q);
$i	= 0;
while($row	= $sql->fetch($rq))
{
  // var_dump($row);
	$field[$i]['name']	= $row['name'];
	$field[$i]['type']	= $row['type'];
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
		$field[$i]['dflt']	= '&lt;none&gt;';
	}
	else
	{
		$field[$i]['dflt']	= $row['dflt_value'];
	}
	
	$field[$i]['pk']		= $row['pk'];
	++$i;
	// var_dump($row);
	// echo '<hr />';
}

$q	= "PRAGMA index_list(".$table_name.")";
$rq	= $sql->query($db,$q);

$i	= 0;

if($sql->size($rq) == '0')
{
	$no_index = TRUE;
}
else
{
	$no_index = FALSE;
	while($row	= $sql->fetch($rq))
	{
		// var_dump($row);
		$inda[$i]['seq']	= $row['seq'];
		$inda[$i]['name']	= $row['name'];
		$inda[$i]['unique']	= $row['unique'];
		
		if (strstr($inda[$i]['name'],'autoindex'))
		{
			$rest	= strstr($inda[$i]['name'],'autoindex');
			$rest	= str_replace('autoindex ','',$rest);
			$rest	= str_replace(')','',$rest);
			$q_index	= "PRAGMA index_info('(".$table_name." autoindex ".$rest.")')";
			$rq_index	= $sql->query($db,$q_index);
			$j	= 0;
			while($row_index	= $sql->fetch($rq_index))
			{
				$inda[$i]['name']	= $row_index['name'];
				++$j;
			}
		}
		else
		{
			$j = 0;
			$q_index	= "PRAGMA index_info('".$inda[$i]['name']."')";
			// echo $q_index;
			$rq_index	= $sql->query($db,$q_index);
			while($row_index	= $sql->fetch($rq_index))
			{
				$inda[$i]['column'][$j]	= $row_index['name'];
				++$j;
			}
		}
		++$i;
		
	}
	//echo '<hr />';
	// var_dump($inda);
	// echo '<hr />';
}

$xh	= new clsWeb;
$head	= new clsHead;
$head->setTitle($index["$taal"]['title']);
$head->setCss('./aSqlite.css');
$head->display();

$body	= new clsBody;

$header_title	= '<span id="zwaartitel">'.$index["$taal"]["header_title"].'</span>';
include_once('header.php');

include_once('./menuleft.php');

$table	= new clsTable;
$table->display();

$table->setTHeader($asqtabledisplay["$taal"]["column_name"]);
$table->setTHeader($asqtabledisplay["$taal"]["column_type"]);
$table->setTHeader($asqtabledisplay["$taal"]["column_null"]);
$table->setTHeader($asqtabledisplay["$taal"]["column_default"]);
$table->setTHeader($asqtabledisplay["$taal"]["column_primary"]);
$table->displayThead();

for($i=0;$i<sizeof($field);++$i)
{
	$tr	= new clsTr;
	$tr->setItem($field[$i]['name']);
	$tr->setItem($field[$i]['type']);
	$tr->setItem($field[$i]['null']);
	$tr->setItem($field[$i]['dflt']);
	$tr->setItem($field[$i]['pk'],"rechts");
	$tr->display();
}
unset($table);

echo '<hr />';

if(!$no_index)
{
	$col = '';
	$tabel = new clsTable;
	$tabel->display();
	for($i=0;$i<sizeof($inda);++$i)
	{
		$tr	= new clsTr;
		$tr->setItem($inda[$i]['name']);
		for($j=0;$j<sizeof($inda[$i]['column']);++$j)
		{
			$col .= $inda[$i]['column'][$j].',';
		}
		$tr->setItem($col);
		$tr->display();
	}
	
	unset($tabel);
}
else
{
	$body->line($asqtabledisplay["$taal"]["no_index"]);
}
$body->line('<hr />'.$sqlstat);
unset($body);
*/
?>