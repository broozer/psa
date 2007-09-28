<?php

include_once('./autoload.php');

$db_name = $_POST['db'];
$table_name = $_POST['table'];
$db_type = $_POST['db_type'];

if($sessie->getS('db_current') != $db_name)
{
	$sessie->setS('db_current',$db_name);
}

$sql = new Sqlite3($datadir.'/'.$db_name,$db_type);

$keys = array_keys($_POST);
$q = "INSERT INTO ".$_POST['table']." (";

$nogo[] = 'db';
$nogo[] = 'table';
$nogo[] = 'db_type';
$nogo[] = 'submit';

# get field names for insert
for($i=0;$i<sizeof($keys);++$i)
{
	if(in_array($keys[$i],$nogo))
	{
		continue;
	}
	$q .= $keys[$i].',';
}

$qlength = strlen($q);
$q = substr($q,0,$qlength-1);
$q .= ") VALUES ('";

# get values for insert
for($i=0;$i<sizeof($keys);++$i)
{
	if(in_array($keys[$i],$nogo))
	{
		continue;
	}
	$q .= $_POST[$keys[$i]]."','";
}
$qlength = strlen($q);
$q = substr($q,0,$qlength-2);

$q .= ")";

$rq = $sql->query($q);

header("location: tableinsert.php?db=".$db_name."&table=".$table_name."&type=".$db_type);
exit;
?>
