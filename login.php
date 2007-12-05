<?php

# users - array - hard coded 
# je maakt een gebruiker aan zoals onderstaand '<naam>'=>'<paswoord>'
# nadien hang je ook een emailadres vast aan de gebruiker :  '<naam>' => '<email>'
$users	= array(
	'wp' => 'hoela',
	'stavvio' => 'tb524'
);
# start authenticatie -> enkel safe op intranet , niet op internet
if (!isset($_SERVER['PHP_AUTH_USER']))
{
	header("HTTP/1.1 401 Unauthorized");
	header('WWW-Authenticate: Basic realm="PHP Secured"');
	exit("Deze pagina is enkel toegankelijk met geldige codes");
}

if (!isset($users[$_SERVER['PHP_AUTH_USER']]))
{
	header("HTTP/1.1 401 Unauthorized");
	header('WWW-Authenticate: Basic realm="PHP Secured"');
	exit("Geen toegang");
}

if ($users[$_SERVER['PHP_AUTH_USER']] != $_SERVER['PHP_AUTH_PW'])
{
	header("HTTP/1.1 401 Unauthorized");
	header('WWW-Authenticate: Basic realm="PHP Secured"');
	exit("Geen toegang");
}

include_once('./class/Session.php');

$sessie = new Session;
$sessie->setS('log_as',TRUE);
header("location: index.php");
exit;

?>