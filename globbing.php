<?php

/* 
globbing.php

one-page search tool for files and patterns in projects

actions :
- give file name or extension and search in all files
- give text pattern and search in all files

*/

function __autoload($class_name)
{
	require_once('../classes/'.$class_name.'.php');
}

$session = new Session;
$req = new Request;

$sub = new Input;
$sub->setName('submit');
$sub->setType('submit');
$sub->setId('submit');

$cmd = new Input;
$cmd->setName('cmd');
$cmd->setSize(30);
$cmd->setType('hidden');

/* Files to loop up - pattern to search for */
$filepat = new Input;
$filepat->setName('filepat');
$filepat->setSize(30);
$filepat->setMaxlength(128);
$filepat->setId('filepat');

/* Text to look up - pattern to search for */
$filetext = new Input;
$filetext->setName('filepat');
$filetext->setSize(30);
$filetext->setMaxlength(128);
$filetext->setId('filetext');

/* files to look in */
$filelist = new Input;
$filelist->setName('filelist');
$filelist->setSize(30);
$filelist->setMaxlength(128);
$filelist->setId('filelist');

/* files to look in */
$filelisttext = new Input;
$filelisttext->setName('filelist');
$filelisttext->setSize(30);
$filelisttext->setMaxlength(128);
$filelisttext->setId('filelisttext');
	
/* shamelessly copied from php.net glob function */
function bfglob($path, $pattern = '*', $flags = 0, $depth = 0) {
   $matches = array();
   $folders = array(rtrim($path, DIRECTORY_SEPARATOR));

   while($folder = array_shift($folders)) {
       $matches = array_merge($matches, glob($folder.DIRECTORY_SEPARATOR.$pattern, $flags));
       if($depth != 0) {
           $moreFolders = glob($folder.DIRECTORY_SEPARATOR.'*', GLOB_ONLYDIR);
           $depth   = ($depth < -1) ? -1: $depth + count($moreFolders) - 2;
           $folders = array_merge($folders, $moreFolders);
       }
   }
   return $matches;
}

$html = new Page;
 
$html->setLanguage('en-EN');
$html->build();

$head = new Head;
$head->setCharset('UTF-8');
$head->setTitle('globbing');
$head->setText('<style type="text/css">
	body { font-size: 1.2em; font-family: monospace;}
	a { background: blue; color: white; }
	table { border-collapse:collapse; }
	th,td { white-space: nowrap; }
	th { background-color: silver; }
	input { background-color: lightyellow; }
	hr { margin-top: 5px; }
	.big { background-color: lightyellow; padding-left: 10px; border: solid 1px orange;}
	.bigtext { font-size: 1.5em; background-color: lightyellow; padding-left: 10px; padding-right: 10px; border: solid 1px orange;}
	.bigsize { font-size: 1.5em; padding-left: 10px; padding-right: 10px;}
	.lineno { background-color: #FFFFBB; }
	.line { background-color: #F0F8FF; }
</style>
<script type="text/javascript"> 
       function checkfiles() {

       	var filepat = document.getElementById("filepat").value;
       	if(filepat === "") {
       		alert("Fill in a value for \'Files to look up\'");
       		return false;
       	}
       	
       	var fileval = document.getElementById("filelist").value;
       	if(fileval === "") {
       		alert("Fill in a value for files to look in");
       		return false;
       	}
       	return true;
       }

        function checktext() {

       	var filetext = document.getElementById("filetext").value;
       	if(filetext === "") {
       		alert("Fill in a value for \'Text to look up\'");
       		return false;
       	}
       	
       	var fileval = document.getElementById("filelisttext").value;
       	if(fileval === "") {
       		alert("Fill in a value for files to look in");
       		return false;
       	}
       	return true;
       }
</script> ');

$head->build();

$body = new Body;
$body->build();

$bodytext = 'nothing to be done';

/* homepage */
if(!$req->is('cmd')) {

	/* 1: search files within files */
	$cmd->setValue('findfiles');
	$cmd->setId('sub');
	$sub->setValue('go');
	
	$form = new Form;
	$form->setAction('globbing.php');
	$form->setJs(' onsubmit="return checkfiles();" ');
	$form->build();

	$table = new Table;
	$table->build();

	$tr = new Tr;
	$tr->add('Files to look up :');
	$tr->add($filepat->dump());
	$tr->add('Files to look in : ');
	$tr->add($filelist->dump());
	$tr->add($sub->dump());
	$tr->add($cmd->dump());
	$tr->build();
	
	unset($table);
	unset($form);

	/* : search text within files */
	$cmd->setValue('findtext');
	$sub->setValue('go');
	
	$form = new Form;
	$form->setAction('globbing.php');
	$form->setJs(' onsubmit="return checktext();" ');
	$form->build();

	$table = new Table;
	$table->build();

	$tr = new Tr;
	$tr->add('Text to look up :');
	$tr->add($filetext->dump());
	$tr->add('Files to look in : ');
	$tr->add($filelisttext->dump());
	$tr->add($sub->dump());
	$tr->add($cmd->dump());
	$tr->build();
	
	unset($table);
	unset($form);


} else {

	$link = new Link;
	$link->setHref('globbing.php');
	$link->setName('Home');
	$link->build();

	$body->line('<hr />');
	
	switch($req->get('cmd')) {
	/* search files with files */
	case 'findfiles': 
		
		// $req->dump();
		$body->line('<h2>File pattern lookup</h2>');
		$css = bfglob('.',$req->get('filepat'),0,5);

		$body->line('<ul class="bigsize">');
		foreach($css as $item) {
			$body->line('<li><span class="big">'.$item.'</span></li>');
			$css2[] = str_replace("\\","/",$item);
		}
		echo '</ul><hr />';

		$body->line('<h2>Files found</h2>');

		$php = bfglob('.',$req->get('filelist'),0,5);

		if(!$php) {
			$body->line('Nothing found');
		} else {

			$table = new Table;
			$table->build();

			$th = new Th;
			$th->add('filename');
			$th->add('line #');
			$th->add('display');
			$th->build();
			
			foreach($php as $item) {
				$fp = new File($item,'r');
			
				$i = 0;
				while($fp->readlines()) {
					++$i;
					foreach($css2 as $cs2) {
						if(stripos($fp->line,$cs2) !== false) {
							$tr = new Tr;
							$tr->add($item);
							$tr->setClas('rechts');
							switch($i) {
								case $i < 10:
									$ti =  str_repeat('&nbsp;',10).$i;
									break;
								case $i < 100:
									$ti =  str_repeat('&nbsp;',9).$i;
									break;
								case $i < 1000:
									$ti =  str_repeat('&nbsp;',8).$i;
									break;
								default:
									$ti = $i;
							}
							
							$tr->add($ti);
							$tr->add(htmlentities($fp->line));
							$tr->build();
						}
					}
					
				}
			}
		}
		break;
	

	case 'findtext': 

		// $body->line('<h2>Files found</h2>');

		$php = bfglob('.',$req->get('filelist'),0,5);

		if(!$php) {
			$body->line('Nothing found');
		} else {

			$body->line('<h2>File pattern lookup</h2>');

			$body->line('Text looked for : <span class="bigtext">'.$req->get('filepat').'</span><br />');
			
			$table = new Table;
			$table->build();

			$th = new Th;
			$th->add('filename');
			$th->add('line #');
			$th->add('display');
			$th->build();
			
			foreach($php as $item) {
				$fp = new File($item,'r');
			
				$i = 0;
				while($fp->readlines()) {
					++$i;
					if(stripos($fp->line,$req->get('filepat')) !== false) {
						$tr = new Tr;
						$tr->add($item);
						$tr->setClas('rechts');
							switch($i) {
								case $i < 10:
									$ti = str_repeat('&nbsp;',10).$i;
									break;
								case $i < 100:
									$ti =  str_repeat('&nbsp;',9).$i;
									break;
								case $i < 1000:
									$ti =  str_repeat('&nbsp;',8).$i;
									break;
								default:
									$ti = $i;
							}
						$tr->add('<span class="lineno">'.$ti.'</span>');

						$linesize = 80 - strlen($fp->line);
						if($linesize > 1) {
							$linespace = str_repeat('&nbsp;',$linesize);
						} else {
							$linespace = '';
						}
						$tr->add('<span class="line">'.htmlentities($fp->line).$linespace.'</span>');
						$tr->build();
					}
					
				}
			}
		}
		break;
	
	default: 
		$body->line('nothing to be done');
	}
}
unset($body);
unset($html);

?>