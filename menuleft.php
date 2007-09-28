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
		$link = new Link;
		$link->setHref('tables.php?name='.$dbar[$i]['name'].'&type='.$dbar[$i]['type']);
		$link->setName($dbar[$i]['name']);
				
		$body->line('<span id="big">'.$link->dump().'</span>');
		// get list of tables in db
		$body->line('<span class="lefter">tables</span>');
		$sql = new Sqlite3($datadir.'/'.$dbar[$i]['name'],$db_type);
		$q	= "SELECT * FROM sqlite_master";
		$rq	= $sql->query($q);

		foreach( $rq as $row ) 
		{
			if($row['type'] == 'table')
			{
				if(isset($table_name))
				{
					if($row['name'] == $table_name)
					{
						$link = new Link;
						$link->setHref('tabledisplay.php?table='.$row['name'].'&db='.$dbar[$i]['name'].'&type='.$dbar[$i]['type']);
						$link->setName($row['name']);
						// $link->setClas('lefter');
						$body->line('<span class="lefterbig">'.$link->dump().'</span>');
					}
					else
					{
						$link = new Link;
						$link->setHref('tabledisplay.php?table='.$row['name'].'&db='.$dbar[$i]['name'].'&type='.$dbar[$i]['type']);
						$link->setName($row['name']);
						$link->setClas('lefter');
						$body->line($link->dump());
					}
				}
				else
				{
					$link = new Link;
					$link->setHref('tabledisplay.php?table='.$row['name'].'&db='.$dbar[$i]['name'].'&type='.$dbar[$i]['type']);
					$link->setName($row['name']);
					$link->setClas('lefter');
					$body->line($link->dump());
				}
			}
		} 
		// echo '<hr />';

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

$body->close();
$html->close();


?>
