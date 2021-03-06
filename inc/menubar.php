<?php

/**
 *type] file
 * [name] menubar.php
 * [package] psa
 * [since] 2010.09.22 - ok
 */

$body->line('<div id="header">php-sqlite-admin
	<p id="menushow">
		<a href="#" onclick="PSA.menutoggle();">[ Show menu ]</a></p>
	</div>');

$body->line('<div id="menu">');

$body->line('<a href="#" onclick="PSA.menutoggle();">Hide menu</a><hr>');
$body->line('dir : <br><span class="ref">'.$sessie->getS('psa-dir').'</span><br>
	ext : <br><span class="ref">'.$sessie->getS('psa-ext').'</span>');
	
if($sessie->isS('psa-db')) {
	$body->line('<br>dba : <br><span class="ref">'.$sessie->getS('psa-db').'</span>');
}
$body->line('<hr>
<ul>
	<li><a href="controller.php">[home]</a></li>
	<li><a href="controller.php?cmd=base">[databases]</a></li>');
	if($sessie->isS('psa-db')) {
		$body->line('
		<li><a href="controller.php?cmd=table">[tables]</a></li>
		<li><a href="controller.php?cmd=query">[query]</a></li>');
	}
	$body->line('<li><a href="controller.php?cmd=bts">[more]</a></li>');
	$body->line('<li><a href="index.php">[log out]</a></li>
</ul>
<hr>
</div>');

$body->line('<div id="content">');

$error_display = 0;
$message_display = 0;
$sqler_display = 0;

if($sessie->isS('psa-error')) {
	$body->line('<div id="error">'.$sessie->getS('psa-error').'</div>');
	$sessie->unsetS('psa-error');
	$error_display = 1;
    
}

if($sessie->isS('psa-message')) {
	$body->line('<div id="message">'.$sessie->getS('psa-message').'</div>');
	$sessie->unsetS('psa-message');
	$message_display = 1;
}
// LITEPDO errors
if($sessie->isS('sqler')) {
	$body->line('<div id="error">');
	$class = $sessie->getS('sqler');
	
	foreach($class->errorInfo as $key => $value) {
		//print $value;
		//print '<hr>';
		if($key == '2') {
	   		$body->line($value);
		}
	}
	
	$body->line('</div>');
	$sessie->unsetS('sqler');
	$sqler_display = 1;
}

if( $error_display == 0 && $message_display == 0 && $sqler_display == 0) {
    $body->line('<div id="blank">&nbsp;</div>');
}
