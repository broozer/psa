<?php

/**
*�[type] file
* [name] menubar.php
* [package] psa
* [since] 2010.09.22 - ok
*/

$body->line('<span id="top"></span><div id="header"> current directory : '
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

if($sessie->isS('sqler')) {
	$body->line('<div id="error">');
	$class = $sessie->getS('sqler');
	// var_dump($class);
	foreach($class->errorInfo as $key => $value) {
		if($key == '2') {
	   			print "$value";
		}
	}
	/*
	echo '<hr />';
	echo $class->errorInfo->2;
	echo '<hr />';
	*/
	$body->line('</div>');
	$sessie->unsetS('sqler');
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
	$body->line('<li><a href="index.php?cmd=bts">[more]</a></li>
</ul>
</div>');

$body->line('<div id="content">');
?>