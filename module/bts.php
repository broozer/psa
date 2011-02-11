<?php

/**
*¨[type] file
* [name] bts.php
* [package] psa
* [since] 2011.02.10
* [expl] documentation avant la lettre - Behind The Screens
*/


$html = new Html;
$html->setDoctype('xhtml-strict');
$html->setLanguage('nl_NL');
$html->build();

$head = new Head;
$head->setCharset('UTF-8');
$head->setTitle('PSA - connection');
$head->setCss('./css/psa.css');
$head->setJs('./js/PSA.js');
$head->build();

$body = new Body;
$body->build();

// include_once('./inc/menubar.php');

$link = new Link;

$link->setHref('index.php');
$link->setName('&nbsp;&nbsp;[Back]');
$link->build();

$body->line('<div class="xemel">');

$xml = simplexml_load_file('./inc/bts.xml');

foreach($xml->item->caption as $cap) {
	echo '<h3>'.$cap->name.'</h3>';
	foreach($cap->para as $paraf) {
		echo '<p>'.$paraf.'</p>';
	}
}

$body->line('</div></div>');
unset($body);
unset($html);

?>