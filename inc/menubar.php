<?php

/**
*¨[type] file
* [name] menubar.php
* [package] psa
* [since] 2010.09.22 - ok
*/

$body->line('<div id="header">php-sqlite-admin');


$body->line('</div>');


$body->line('<div id="menu">
	dir : <br><span class="ref">'.$sessie->getS('psa-dir').'</span><br>
	ext : <br><span class="ref">'.$sessie->getS('psa-ext').'</span>');
	
if($sessie->isS('psa-db')) {
	$body->line('</span><br>
	dba : <br><span class="ref">'.$sessie->getS('psa-db')).'</span>';
}
$body->line('<hr>
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
<hr>
</div>');

$body->line('<div id="content">');


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
	
	$body->line('</div>');
	$sessie->unsetS('sqler');
}

?>