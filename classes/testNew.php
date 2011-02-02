<?php

include_once('./Session.php');
include_once('./Web.php');
include_once('./Html.php');

$html = new Html;
$html->setDoctype('xhtml-strict');
$html->setLanguage('nl');
$html->build();

?>