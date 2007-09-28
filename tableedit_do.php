<?php

include_once('./autoload.php');

// var_dump($_POST);
$db_name = $_POST['db'];
$table_name = $_POST['table'];
$db_type = $_POST['db_type'];

if($sessie->getS('db_current') != $db_name)
{
	$sessie->setS('db_current',$db_name);
}

$sql = new Sqlite3($datadir.'/'.$db_name,$db_type);

$keys = array_keys($_POST);
$q = "UPDATE ".$_POST['table']." SET ";

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
	/*if($keys[$i] == 'id')
	{
		continue;
	}
	*/
	$q .= $keys[$i]."='".$_POST[$keys[$i]]."', ";
}

$qlength = strlen($q);
$q = substr($q,0,$qlength-2);

$q .= " WHERE ROWID = ".$_POST['id'];

/**/
$rq = $sql->query($q);

header("location: tablebrowse.php?db=".$db_name."&table=".$table_name."&type=".$db_type);
exit;
/**/
?>
