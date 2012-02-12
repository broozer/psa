<?php

/**
*�[type] file
* [name] query_results.php
* [package] psa
* [since] 2010.09.22 -ok
*/

$res = unserialize($sessie->getS('psa-results'));
$sessie->unsetS('psa-results');

$html = new Page;
 
$html->setLanguage('nl_NL');
$html->build();

$head = new Head;
$head->setCharset('UTF-8');
$head->setTitle('PSA - query results');
$head->setCss('./css/psa.css');
$head->setJs('./js/PSA.js');
$head->build();

$body = new Body;
$body->build();

include_once('./inc/menubar.php');
$body->line('Executed query : <br />');
$body->line('<p class="qs">'.$sessie->getS('psa-query-results').'<hr />');
$sessie->unsetS('psa-query-results');
$titles = FALSE;

if(!$res) {
	$body->line('no further feedback');
} else {
	$table = new Table;
	$table->setClas('result');
	$table->setId('listing');
	$table->build();
	$odd = TRUE;
	
	foreach($res as $item) {
		if(!$titles) {
			$tr = new Th;
			$names = array_keys(get_object_vars($item));
			foreach($names as $title) {
				$tr->add($title);
			}
			$tr->build();
			$titles = TRUE;
		}
		$tr = new Tr;
		if($odd) {
			$tr->setGlobalClass('even');
			$odd = FALSE;
		} else {
			$tr->setGlobalClass('odd');
			$odd = TRUE;
		}
		
		foreach($item as $data) {
			// display odd characters
			$tr->add(htmlentities($data));
		}
		$tr->build();
	}
	
	unset($table);
}

$body->line('</div>');
include_once('./inc/footer.php');
unset($body);
unset($html);
?>