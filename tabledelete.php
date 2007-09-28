<?php

include_once('./autoload.php');

// var_dump($_GET);
$db_name = $_GET['db'];
$table_name = $_GET['table'];
$db_type = $_GET['type'];

if($sessie->getS('db_current') != $db_name)
{
	$sessie->setS('db_current',$db_name);
}
/*
if(!$sessie->isS('tbls'))
{
*/
$sql = new Sqlite3($datadir.'/'.$db_name,$db_type);
$q = "DELETE FROM ".$table_name." WHERE ROWID = ".$_GET['rowid'];

$rq = $sql->query($q);

header("location: tablebrowse.php?db=".$db_name."&table=".$table_name."&type=".$db_type);
exit;
?>
