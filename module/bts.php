<?php

/**
*¨[type] file
* [name] bts.php
* [package] psa
* [since] 2011.02.10
* [expl] documentation avant la lettre - Behind The Screens
*/


$html = new Page;
 
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

include_once('./inc/menubar.php');

$body->line('<div class="xemel">');

$xml = simplexml_load_file('./inc/bts.xml');

// menu
foreach($xml->item->caption as $cap) {
	$link = new Link;
	// $link->setHref('#'.$cap->name);

	$body->line('<a href="#'.$cap->name.'" >'.$cap->name.'</a><br />');
}

$body->line('<hr />');

// content

foreach($xml->item->caption as $cap) {

	$body->line('<h3><a name="'.$cap->name.'">'.$cap->name.'</a></h3>');
	foreach($cap->para as $paraf) {
		$body->line('<p>'.$paraf.'</p>');
	}
	$body->line('<a href="#top">&lt;==</a><br /><br />');
}

$body->line('</div></div>');
include_once('./inc/footer.php');
unset($body);
unset($html);

