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

$query = new Link;
$query->setHref('query.php');
$query->setName($text['query']);

$drop = new Link;
$drop->setHref('droptable.php?table='.$table_name.'&db='.$db_name);
$drop->setName($text['drop']);
$drop->setJs('onClick="return confirm(\''.$text['remove'].'\')"');

$body->line('<p id="menubar">');

$struct->build();
$query->build();
$body->line($text['search']);
$drop->build();

$body->line('</p>');

?>