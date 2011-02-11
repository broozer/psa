<?php

/**
*¨[type] file
* [name] menubar.php
* [package] psa
* [since] 2010.09.22 - ok
*/

$body->line('<div id="header"> current directory : '
	.$sessie->getS('psa-dir'). ' - current extension : '.$sessie->getS('psa-ext'));
if($sessie->isS('psa-db')) {
	$body->line(' - current database : '.$sessie->getS('psa-db'));
}

$body->line('</div>');

if($sessie->isS('psa-error')) {
	$body->line('<div id="error">'.$sessie->getS('psa-error').'</div>');
	$sessie->unsetS('psa-error');
}

if($sessie->isS('psa-message')) {
	$body->line('<div id="message">'.$sessie->getS('psa-message').'</div>');
	$sessie->unsetS('psa-message');
}
	
$body->line('<div id="menu">
<ul>
	<li><a href="index.php">[home]</a></li>
	<li><a href="index.php?cmd=base">[databases]</a></li>');
	if($sessie->isS('psa-db')) {
		$body->line('
		<li><a href="index.php?cmd=table">[tables]</a></li>
		<li><a href="index.php?cmd=query">[query]</a></li>');
	}
$body->line('</ul>
</div>');

$body->line('<div id="content">');
?>