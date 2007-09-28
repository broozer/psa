<?php

/*
** [type] file
** [name] menubar.php
** [author] Wim Paulussen
** [since] 2007-03-25
** [update] 2007-03-25 - start
** [expl] menubar for tables.php
** [end]
*/

$query = new Link;
$query->setHref('query.php');
$query->setName($text['query']);

$vacuum = new Link;
$vacuum->setHref('vacuum.php');
$vacuum->setName($text['vacuum']);

$drop = new Link;
$drop->setHref('dropdb.php?name='.$db_name);
$drop->setName($text['drop']);
$drop->setJs('onClick="return confirm(\''.trim($text['remove']).'\')"');

$body->line('<p id="menubar">');

$query->build();
$vacuum->build();
$drop->build();

$body->line('</p>');

?>