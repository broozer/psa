<?php

/**
 * [type] file
 * [name] ./inc/footer.php
 * [package] psa
 * [since] 2010.09.22
 */
 
$body->line('
</div>
<div id="footer">');

if($req->is('cmd')) {
    $body->line($req->get('cmd')." - ");
}
$body->line('
psa - current version 0.2.0.0
</div>');
unset($html);