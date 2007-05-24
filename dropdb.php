<?php

/*
** [type] file
** [name] dropdb.php
** [author] Wim Paulussen
** [since] 2007-03-25
** [update] 2007-03-25 - start
** [expl] drop database
** [end]
*/

include_once('./autoload.php');

$language = new Language('dropdb',$lang);
$text = $language->getText();

$sessie->unsetS('dbs');
if($sessie->isS('tbls'))
{
	$sessie->unsetS('tbls');
}

if(@unlink($datadir."/".$_GET['name']))
{
	// NOTE: table with dbs changed
	
	$sessie->setS('s_error',$text["dropped"]);
	header("location: index.php");
	exit;
}
else
{	
	$sessie->setS('s_error',$text["unable"]);
	header("location: index.php");
	exit;
}

?>
