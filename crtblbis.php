<?php

/*
** [file] crttblbis.php
** [author] Wim Paulussen
** [since] 2007-04-13
** [update] 2007-04-13 - start
** [expl] 
** [end]
*/

include_once('./autoload.php');

// var_dump($_POST);

error_reporting(E_ALL&~E_NOTICE);
$table_name		= $_POST['table'];
$db_name		= $_POST['database'];
$db_type		= $_POST['db_type'];

unset($_POST['table']);
unset($_POST['database']);
unset($_POST['db_type']);
unset($_POST['submit']);

if($sessie->isS('tbls'))
{
	$sessie->unsetS('tbls');
}

$j	= -1;

for($i=0;$i<sizeof($_POST);++$i)
{
	if(isset($_POST['field'.$i]))
	{
		$new 	= TRUE;
		$pointer = $i;
		++$j;
		$fields[$j]['name'] = $_POST['field'.$i];
	}
	
	if(isset($_POST['type'.$pointer]))
	{
		$fields[$j]['type']	= $_POST['type'.$pointer];
	}
	
	if(isset($_POST['null'.$pointer]))
	{
		$fields[$j]['null']	= TRUE;
	}
	else
	{
		$fields[$j]['null']	= FALSE;
	}
	
	if(isset($_POST['length'.$pointer])&&$_POST['length'.$pointer] != '')
	{
		$fields[$j]['length']	= $_POST['length'.$pointer];
	}
	
	if(isset($_POST['dflt'.$pointer]))
	{
		$fields[$j]['dflt']	= $_POST['dflt'.$pointer];
	}
	
	if(isset($_POST['unique'.$pointer]))
	{
		$fields[$j]['unique']	= TRUE;
	}
	else
	{
		$fields[$j]['unique']	= FALSE;
	}
		
	if(isset($_POST['pk'.$pointer]))
	{
		$fields[$j]['pk']	= TRUE;
	}
	else
	{
		$fields[$j]['pk']	= FALSE;
	}
}

// die('tot hier en niet verder !');

if(!$sql	= new Sqlite3($datadir.'/'.$db_name,$db_type))
{
	die('hier stopt de pret');
}

$q	= "CREATE TABLE ".$table_name." (";

$j	= sizeof($fields);

for ($i=0;$i<$j;++$i)
{
	if ($fields[$i]['name'] == '')
	{
		continue;
	}
	else
	{
		$q	.= $fields[$i]['name']." ";
		// if field is primary key
		if($fields[$i]['pk'])
		{
			$q	.= " INTEGER PRIMARY KEY ";
		}
		else
		{
			$q	.= $fields[$i]['type'];
	
			if (isset($fields[$i]['length']))
			{
				$q .=  "(".$fields[$i]['length'].")";
			}
			$q	.= " ";
			if($fields[$i]['null'])
			{
				$q .= " NULL ";
			}
			else
			{
				$q .= " NOT NULL ";
			}
			
			if($fields[$i]['dflt'] != '')
			{
				if (is_numeric($fields[$i]['dflt']))
				{
					$q .= " DEFAULT ".$fields[$i]['dflt']." ";
				}
				else
				{
					$q .= " DEFAULT '".$fields[$i]['dflt']."' ";
				}
			}
			if($fields[$i]['unique'])
			{
				$q .= " UNIQUE";
			}
			
		}
		if ($i < ($j-1))
		{
			$q .=", ";
		}
	}
}

$q .= ")";

if(!$rq	= $sql->query($q))
{
	$sessie->setS('s_error','Query not executable (table already exists ?)');
}

header("location: tables.php?name=".$db_name."&type=".$db_type);
exit;

?>
