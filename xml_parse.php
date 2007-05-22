<?php

/*
** [type] file
** [name] autoload.php
** [author] Wim Paulussen
** [since] 2007-05-21
** [update] 2007-05-21 = start
** [expl] autoload 
** [end]
*/

$xml	= simplexml_load_file('./xml/psa.xml');

foreach ($xml->xpath('//psa') as $character) 
{
	foreach($character->param as $item)
	{
		if($item['type']	== 'extension')
		{
			$ext	= $item;
		}
		if($item['type']	== 'language')
		{
			$lang = $item;
		}
		if($item['type'] == 'datadir')
		{
			$datadir = $item;
		}
	}
}

?>
