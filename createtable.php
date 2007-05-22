<?php

/*
** [type] file
** [name] createtable.php
** [author] Wim Paulussen
** [since] 2007-03-25
** [update] 2007-03-25 - start
** [expl] create table
** [end]
*/
include_once('./autoload.php');

// NOTE check if name already exists
$table_name		= $_POST['table'];
$db_name		= $_POST['database'];
$db_type		= $_POST['db_type'];
$fields			= $_POST['fields'];

$language = new Language('createtable',$lang);
$text = $language->getText();

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

// DEBUG: include menuleft.php
include_once('menuleft.php');

$body->line('
<div id="content">');

include_once('menubar.php');

$form	= new Form;
$form->setAction('crtblbis.php');
$form->build();

$table	= new Table;
$table->build();


$th = new Th;
$th->addElement($text['col_name'],'');
$th->addElement($text['col_type'],'');
$th->addElement($text['col_length'],'');
$th->addElement($text['col_null'],'');
$th->addElement($text['col_default'],'');
$th->addElement($text['col_primary'],'');
$th->addElement($text['col_unique'],'');
$th->build();

$inp_db	= new Input;
$inp_db->setName('database');
$inp_db->setValue($_POST['database']);
$inp_db->setSize('128');
$inp_db->setType('hidden');

$inp_dbt	= new Input;
$inp_dbt->setName('db_type');
$inp_dbt->setValue($_POST['db_type']);
$inp_dbt->setSize('128');
$inp_dbt->setType('hidden');

$inp_table	= new Input;
$inp_table->setName('table');
$inp_table->setValue($_POST['table']);
$inp_table->setSize('128');
$inp_table->setType('hidden');

$body->line('<tbody id="fs">');

$tr	= new Tr;
$tr->addElement($inp_db->build());
$tr->addElement($inp_dbt->build());
$tr->addElement($inp_table->build());
$tr->build();

for ($i=0;$i<$_POST['fields'];++$i)
{
	$inp_name	= new Input;
	$inp_name->setName('field'.$i);
	$inp_name->setSize('15');
	$inp_name->setMaxlength('128');

	$inp_type	= new Select;
	$inp_type->setName('type'.$i);
	$inp_type->setSize(1);
	// $inp_type->setOpt(' ',' ');
	$inp_type->addElement('INTEGER','INTEGER');
	$inp_type->addElement('CHAR','CHAR');
	$inp_type->addElement('VARCHAR','VARCHAR');
	$inp_type->addElement('DATE','DATE');
	$inp_type->addElement('TIME','TIME');
	$inp_type->addElement('DECIMAL','DEMICAL');
	$inp_type->addElement('FLOAT','FLOAT');
	$inp_type->addElement('TEXT','TEXT'); // not ANSI SQL-92

	$inp_length	= new Input;
	$inp_length->setName('length'.$i);
	$inp_length->setSize('5');
	$inp_length->setMaxlength('5');
	
	$inp_null	= new Input;
	$inp_null->setName('null'.$i);
	$inp_null->setType('checkbox');
	
	$inp_dflt	= new Input;
	$inp_dflt->setName('dflt'.$i);
	$inp_dflt->setSize('15');
	$inp_dflt->setMaxlength('128');
	
	$inp_pk	= new Input;
	$inp_pk->setName('pk'.$i);
	$inp_pk->setType('radio');
	
	$inp_unique	= new Input;
	$inp_unique->setName('unique'.$i);
	$inp_unique->setType('checkbox');

		
	
	$tr	= new Tr;
	$tr->addElement($inp_name->build());
	$tr->addElement($inp_type->build());
	$tr->addElement($inp_length->build());
	$tr->addElement($inp_null->build());
	$tr->addElement($inp_dflt->build());
	$tr->addElement($inp_pk->build(),"midden");
	$tr->addElement($inp_unique->build(),"midden");
	$tr->build();
}

$body->line('</tbody>');
$table->close();

$sub	= new Input;
$sub->setName('submit');
$sub->setType('submit');
$sub->setValue($text['submit']);

$body->line($sub->build());

$form->close();

$body->line('</div>
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
