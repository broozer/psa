<?php

/*
** [type] file
** [name] createdb.php
** [author] Wim Paulussen
** [since] 2007-03-25
** [update] 2007-04-14 - delete sessie var tbls
** [expl] creation of new database
** [end]
*/
include_once('./autoload.php');

$name	= $_POST['database'];
$name	= $datadir."/".str_replace(" ","_",$name).".".$ext;
// NOTE: first check existence - if exists -> throw error
if(file_exists($name))
{
	$sessie->setS('s_error','Database already exists.');
	header('location: index.php');
	exit;
}
// NOTE: creation of database
$sql	= new Sqlite3($name);
unset($sql);

$sessie->unsetS('dbs');

if($sessie->isS('tbls'))
{
	$sessie->unsetS('tbls');
}

header('location: index.php');
exit;

?>
