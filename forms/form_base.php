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
$tr->add('Directory : ');
$tr->add($inp_dir->dump());
$tr->add($cmd->dump());
$tr->build();

$tr = new Tr;
$tr->add('Extension : ');
$tr->add($inp_ext->dump());
$tr->build();

$tr = new Tr;
$tr->add('&nbsp;');
$tr->add($submit->dump());
$tr->build();

unset($table);
unset($form);

?>