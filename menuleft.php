<?php

/*
** [file]
** [name] menuleft.php
** [author] Wim Paulussen
** [since] 2007-03-24
** [update] 2007-03-24 - start
** [expl] menu buildup
** [end]
*/

$body->line('<div id="navigation">');

$link	= new Link;
$link->setHref('index.php');
$link->setName($text['home']);
$link->build();

$link	= new Link;
$link->setHref('config.php');
$link->setName($text['config']);
$link->build();

$link	= new Link;
$link->setHref('changelog.php');
$link->setName($text['changelog']);
$link->build();

$body->line('<hr />databases<br />');

$dbar = $sessie->getS('dbs');
for($i=0;$i<sizeof($dbar);++$i)
{
	if($sessie->isS('db_current') && $sessie->getS('db_current') == $dbar[$i]['name'])
	{
		$body->line('<span id="big">'.$dbar[$i]['name'].'</span><hr />');
		// get list of tables in db
		$sql = new Sqlite3($datadir.'/'.$dbar[$i]['name'],$db_type);
		$q	= "SELECT * FROM sqlite_master";
		$rq	= $sql->query($q);
	
		foreach( $rq as $row ) 
		{
			if($row['type'] == 'table')
			{
				$link = new Link;
				$link->setHref('tabledisplay.php?table='.$row['name'].'&db='.$dbar[$i]['name']);
				$link->setName($row['name']);
				$link->setClas('lefter');
				$body->line($link->dump());
			}
		} 
		echo '<hr />';

	}
	else
	{
		$link = new Link;
		$link->setHref('tables.php?name='.$dbar[$i]['name'].'&type='.$dbar[$i]['type']);
		$link->setName($dbar[$i]['name']);
		$link->build();
	}

	// show tables

}

$body->line('</div>');

/*
$body->line('<span id="zwaar"><a href="asqtables.php?name='.$_GET['db'].'">'.$_GET['db'].'</a></span><br />');
$body->line('<span id="zwaar">'.$table_name.'</span>');
$body->line();

$table = new clsTable;
$table->display();

$link	= new clsLink;
$link->setHref('asqtabledisplay.php?table='.$table_name.'&amp;db='.$db_name);
$link->setName($asqtabledisplay["$taal"]["structure"]);
$tr	= new clsTr;
$tr->setitem($link->dump());
$tr->display();

$link	= new clsLink;
$link->setHref('asqtablebrowse.php?table='.$table_name.'&amp;db='.$db_name);
$link->setName($asqtabledisplay["$taal"]["browse"]);
$tr	= new clsTr;
$tr->setitem($link->dump());
$tr->display();

$link	= new clsLink;
$link->setHref('asqtableinsert.php?table='.$table_name.'&amp;db='.$db_name);
$link->setName($asqtabledisplay["$taal"]["insert"]);
$tr	= new clsTr;
$tr->setitem($link->dump());
$tr->display();

$link	= new clsLink;
$link->setHref('asqtableempty.php?table='.$table_name.'&amp;db='.$db_name);
$link->setName($asqtabledisplay["$taal"]["empty"]);
$link->setJava('onClick="return confirm(\''.$asqtables["$taal"]['emptytable'].'\')');
$tr	= new clsTr;
$tr->setitem($link->dump());
$tr->display();

$link	= new clsLink;
$link->setHref('asqtabledrop.php?table='.$table_name.'&amp;db='.$db_name);
$link->setName($asqtabledisplay["$taal"]["drop"]);
$link->setJava('onClick="return confirm(\''.$asqtables["$taal"]['droptable'].'\')');
$tr	= new clsTr;
$tr->setitem($link->dump());
$tr->display();

unset($table);

$body->line('</div><div>');
*/

?>
