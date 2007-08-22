<?php

$topper = 'directory : <span id="blueback">'.$datadir.'</span> - extension : <span id="blueback">'.$ext.'</span> ';

if($sessie->isS('db_current'))
{
	$topper .= ' database : <span id="blueback">'.$sessie->getS('db_current').'</span> ';
}

if(isset($table_name))
{
	$topper .= ' table : <span id="blueback">'.$table_name.'</span> ';
}

$body->line($topper);

?>
