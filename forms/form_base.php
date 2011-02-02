<?php

/**
*¨[type] file
* [name] form_base.php
* [package] psa
* [since] 2010.09.22 -ok
*/

$form = new Form;
$form->setAction('index.php');
$form->build();

$table = new Table;
$table->build();

$tr = new Tr;
$tr->addElement('Directory : ');
$tr->addElement($inp_dir->dump());
$tr->addElement($cmd->dump());
$tr->build();

$tr = new Tr;
$tr->addElement('Extension : ');
$tr->addElement($inp_ext->dump());
$tr->build();

$tr = new Tr;
$tr->addElement('&nbsp;');
$tr->addElement($submit->dump());
$tr->build();

unset($table);
unset($form);

?>