<?php

/**
*¨[type] file
* [name] inp_base.php
* [package] psa
* [since] 2010.09.22 - ok
*/

$inp_dir =  new Input;
$inp_dir->setName('directory');
$inp_dir->setSize(50);
$inp_dir->setValue($result->directory);

$inp_ext = new Input;
$inp_ext->setName('extension');
$inp_ext->setSize(10);
$inp_ext->setValue($result->extension);

?>