<?php

/*
** [type] file
** [name] droptable.php
** [author] Wim Paulussen
** [since] 2007-08-22
** [update] 2007-08-22 - start
** [expl] drop table
** [end]
*/

include_once('./autoload.php');

$table_name	= $_GET['table'];
$db_name	= $_GET['db'];
$db_type	= 0;

if(!$sql	= new Sqlite3($datadir.'/'.$db_name,$db_type))
{
	die('hier stopt de pret');
}

$q	= "DROP TABLE ".$table_name;
$rq	= $sql->query($q);

if($sessie->isS('query_error'))
{
	$sessie->setS('s_error','Query not executable (table already exists ?)');
}
else
{
	$sessie->setS('s_error',$table_name.' dropped');
}
header("location: tables.php?name=".$_GET['db'].'&type=0');
exit;

?>
