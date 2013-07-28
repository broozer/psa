<?php

/**
*¨[type] file
* [name] form_base.php
* [package] psa
* [since] 2010.09.22 -ok
*/

$inp_dir =  new Input;
$inp_dir->setName('directory');
$inp_dir->setSize(50);
$inp_dir->setValue($result->directory);

$inp_ext = new Input;
$inp_ext->setName('extension');
$inp_ext->setSize(10);
$inp_ext->setValue($result->extension);

$inp_lines = new Input;
$inp_lines->setName('nr_rows');
$inp_lines->setSize(7);
$inp_lines->setValue($result->nr_rows);

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
$tr->add('# records in view : ');
$tr->add($inp_lines->dump());
$tr->build();


$tr = new Tr;
$tr->add('&nbsp;');
$tr->add($submit->dump());
$tr->build();

unset($table);
unset($form);
