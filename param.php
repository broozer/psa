<?php

/*
** [type] file
** [name] param.php
** [author] Wim Paulussen
** [since] 2007-03-25
** [update] 2007-03-25 - start
** [expl] update configuration parameters
** [end]
*/

include_once('./autoload.php');

// check if directory exists
$dir	= $_POST['directory'];
if(!file_exists($dir))
{
	$sessie->setS('s_error','Directory does not exist');
	header('location: config.php');
	exit;
}

$xml	= simplexml_load_file('./xml/psa.xml');
$xml->param[0]	= $_POST['extension'];
$xml->param[1] = $_POST['directory'];
$xml->param[2] = $_POST['language'];

$tekst	= $xml->asXML();

$best	= new File('./xml/psa.xml','w');
$best->writelines($tekst);
unset($best);

switch($_POST['language'])
{
	case 'en':
		$text = 'Parameters updated.';
		break;

	case 'nl':
		$text = 'Parameters aangepast.';
		break;

	default:
		$text = 'Parameters updated.';
		break;
}

$sessie->setS('s_error',$text);
header('location: config.php');
exit;

?>
