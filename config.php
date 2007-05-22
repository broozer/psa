<?php

/*
** [type] file
** [name] config.php
** [author] Wim Paulussen
** [since] 2007-03-24
** [update] 2007-03-24 - start
** [expl] configuration parameters
** [end]
*/
include_once('./autoload.php');

// NOTE: reset table with dbs
if($sessie->isS('db_current'))
{
	$sessie->unsetS('db_current');
}
$language = new Language('config',$lang);
$text = $language->getText();

$langar[0]['short']		= 'en';
$langar[0]['val']		= 'English';
$langar[1]['short']		= 'nl';
$langar[1]['val']		= 'Nederlands';

$inp_dir	= new Input;
$inp_dir->setName('directory');
$inp_dir->setSize(50);
$inp_dir->setMaxLength(128);
$inp_dir->setValue($datadir);

$inp_lang	= new Select;
$inp_lang->setName('language');
$inp_lang->setSize(1);
$inp_lang->setSelected($lang);

for($i=0;$i<sizeof($langar);++$i)
{
	$inp_lang->addElement($langar[$i]['short'],$langar[$i]['val']);
}

$inp_ext = new Input;
$inp_ext->setName('extension');
$inp_ext->setSize(12);
$inp_ext->setValue($ext);

$submit	= new Input;
$submit->setName('submit');
$submit->setType('submit');
$submit->setSize('25');
$submit->setValue($text['submit']);


$html	= new Html;
$html->setDoctype('xhtml-strict');
$html->setLanguage('en');
$html->build();

$head	= new Head;
$head->setTitle($text['title']);
$head->setCss('./css/psa.css');
$head->build();

$body	= new Body;
$body->build();

$body->line('
<div class="page">
<div id="header">
		<!-- <p class="centraal">'.$text['header'].'<p> -->
</div>');

include_once('menuleft.php');

$body->line('<div id="content"><p>&nbsp</p>');

$formpar = new Form;
$formpar->setAction('param.php');
$formpar->build();

$tabel	= new Table;
$tabel->build();

$tr	= new Tr;
$tr->addElement($text['lang']);
$tr->addElement($inp_lang->build());
$tr->build();

$tr	= new Tr;
$tr->addElement($text['basedir']);
$tr->addElement($inp_dir->build());
$tr->build();

$tr	= new Tr;
$tr->addElement($text['ext']);
$tr->addElement($inp_ext->build());
$tr->build();

$tr	= new Tr;
$tr->addElement('');
$tr->addElement($submit->build());
$tr->build();

$tabel->close();
$formpar->close();

$body->line('</div>');
$body->line('
<div id="footer">
	<p class="rechts">&copy; 
		<a href="http://www.asgc.be">
			www.asgc.be
		</a>
	</p>
</div>
</div>');



$body->close();
$html->close();

?>