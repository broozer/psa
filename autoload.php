<?php

/*
** [type] file
** [name] autoload.php
** [author] Wim Paulussen
** [since] 2007-05-21
** [update] 2007-08-22 - update layout
** [expl] autoload 
** [end]
*/


error_reporting(E_ALL | E_STRICT);	// NOTE: for development purposes

function __autoload($class_name)
{
	require_once('./class/'.$class_name.'.php');
}

$sessie = new Session;

// NOTE: check existence of psa.xml. If it does not exist, it will be created with standards

if(!file_exists('./xml/psa.xml'))
{
	$fp = new File('./xml/psa.xml','w');
	$lijn = '<?xml version="1.0" ?>'."\n";
	$lijn .= '<psa>'."\n";
	$lijn .= "\t".'<param type="extension">sdb</param>'."\n";
	$lijn .= "\t".'<param type="datadir">./</param>'."\n";
	$lijn .= "\t".'<param type="language">en</param>'."\n";
	$lijn .= '</psa>'."\n";
	$fp->writelines($lijn);
	unset($fp);
}
	
include_once('./xml_parse.php');

if(!file_exists('./xml/psalang_'.$lang.'.xml'))
{
	die("file 'psalang_".$lang.".xml' is needed. Download it from the project download page to get this working !");
}

if (!$sessie->isS('dbs'))
{
	$psa = new Psa;
	$dbar = $psa->getDb($datadir,$ext);
	$sessie->setS('dbs',$dbar);
}

?>
