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

$query = new Link;
$query->setHref('query.php');
$query->setName($text['query']);

$drop = new Link;
$drop->setHref('droptable.php?table='.$table_name.'&db='.$db_name);
$drop->setName($text['drop']);
$drop->setJs('onClick="return confirm(\''.$text['remove'].'\')"');

$body->line('<p id="menubar">');

$query->build();
$body->line($text['search'].'&nbsp;'.$text['structure']);
$drop->build();

$body->line('</p>');

?>