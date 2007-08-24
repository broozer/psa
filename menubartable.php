<?php

/*
** [type] file
** [name] menubartable.php
** [author] Wim Paulussen
** [since] 2007-06-05
** [update] 2007-06-05 - start
** [expl] menubar for tables.php
** [end]
*/

$struct  = new Link;
$struct->setHref('tabledisplay.php?table='.$table_name.'&db='.$db_name.'&type=0');
$struct->setName($text['structure']);

$insert  = new Link;
$insert->setHref('tableinsert.php?table='.$table_name.'&db='.$db_name.'&type=0');
$insert->setName($text['insert']);

$browse  = new Link;
$browse->setHref('tablebrowse.php?table='.$table_name.'&db='.$db_name.'&type=0');
$browse->setName($text['browse']);

$query = new Link;
$query->setHref('query.php?table='.$table_name.'&db='.$db_name.'&type=0');
$query->setId('test');
$query->setName($text['query']);

$drop = new Link;
$drop->setHref('droptable.php?table='.$table_name.'&db='.$db_name);
$drop->setJs('onClick="return confirm(\''.$text['remove'].'\')');
$drop->setName($text['drop']);


$body->line('<p id="menubar">');

$struct->build();
$insert->build();
$browse->build();
$query->build();
$drop->build();

$body->line('</p>');

?>