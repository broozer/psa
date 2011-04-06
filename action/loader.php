<?php

/**
* [type] file
* [name] loader.php
* [package] psa
* [author] Wim Paulussen
* [since] 2011.04.04
* [expl] autoload for ajax requests
*/

function __autoload($class_name)
{
	require_once('../classes/'.$class_name.'.php');
}

// $sessie = new Session;
$req = new Request;


?>
