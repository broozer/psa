<?php

/*
** [type] file
** [name] autoload.php
** [author] Wim Paulussen
** [since] 2007-05-21
** [update] 2007-05-21 - start
** [expl] autoload 
** [end]
*/


error_reporting(E_ALL | E_STRICT);	// NOTE: for development purposes

function __autoload($class_name)
{
	require_once('./class/'.$class_name.'.php');
}

$sessie = new Session;

// NOTE: check existence of psa.xml 

if(!file_exists('./xml/psalang.xml'))
{
	die("file 'psalang.xml' is needed. Get it to get this working !");
}

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

if (!$sessie->isS('dbs'))
{
	$psa = new Psa;
	$dbar = $psa->getDb($datadir,$ext);
	// DEBUG: var_dump($dbar);
	$sessie->setS('dbs',$dbar);
}

// DEBUG: echo $taal,$dir,$ext;
?>
