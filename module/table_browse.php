<?php

/**
* [type] file
* [name] table_browse.php
* [package] psa
* [since] 2010.10.20 -ok 
* [update] 2012-08-12 : browse Limit at end - false no data message
			 2012-08-12 : views cannot be edited !
*/

// PAGING

// bottom : low end record
// bottom_table : table last viewed 
if(!$sessie->isS('bottom')) {
	$sessie->setS('bottom',0);
	$sessie->setS('bottom_table',$req->get('table'));
}

// if table not the same , reset pointer

if($sessie->getS('bottom_table') !== $req->get('table')) {
	$sessie->setS('bottom',0);
	$sessie->setS('bottom_table',$req->get('table'));
}

// if view type , no editing
if($req->is('view')) {
	$is_view = $req->get('view');
} else {
	$is_view = false;
}


$sql = new LitePDO('sqlite:'
	.$sessie->getS('psa-dir').'/'
	.$sessie->getS('psa-db').'.'
	.$sessie->getS('psa-ext').'');

$q = "SELECT count(*) as count FROM ".$req->get('table')." ";
$sql->qo($q);
$res = $sql->fo_one();
$records = $res->count;
$pages = floor($records/LIMIT);
$lastpage = round($pages,0)*LIMIT;
// if LIMIT lastpage == $records : false mention no data workaround
if($records > 0) {
	// echo 'data exist';

	if($records == $lastpage) {
		// echo $records.'-'.$lastpage;
		$lastpage = $lastpage - LIMIT;
	}
}

$q = "PRAGMA table_info('".$req->get('table')."')";
$sql->qo($q);
$res = $sql->fo();

$pk = false;

foreach($res as $item) {
	if($item->name == 'id') {
		$pk = true;
	}
	$col[] = $item->name;
}

// echo 'lastpage val : '.$lastpage.'<hr />';

if($req->get('direction') == 'last') {
	$sessie->setS('bottom',$lastpage);
}

if($req->get('direction') == 'first') {
	$sessie->setS('bottom',0);
}

if($req->get('direction') == 'next') {
	$bottom = $sessie->getS('bottom')+ LIMIT;
	
	if($bottom <= $lastpage) {
		$sessie->setS('bottom',$bottom);
	}
}

if($req->get('direction') == 'previous') {
	$bottom = $sessie->getS('bottom') - LIMIT;
	if($bottom >= 0) {
		$sessie->setS('bottom',$bottom);
	}
}

if($pk) {
	$q = "SELECT * FROM ".$req->get('table')." LIMIT ".$sessie->getS('bottom').",".LIMIT." ";
} else {
	$q = "SELECT ROWID as id,* FROM ".$req->get('table')." LIMIT ".$sessie->getS('bottom').",".LIMIT." ";
}

// echo $q;

$sql->qo($q);

$res = $sql->fo();
/*
var_dump($_SESSION);
var_dump($res);
*/
// echo "BOTTOM WAARDE  : <b><h1>".$sessie->getS('bottom')."</h1></b>";

$html = new Page;
 
$html->setLanguage('nl_NL');
$html->build();

$head = new Head;
$head->setCharset('UTF-8');
$head->setTitle('PSA - query results');
$head->setCss('./css/psa.css');
$head->setjs('./js/PSA.js');
$head->build();

$body = new Body;
$body->build();

include_once('./inc/menubar.php');

$body->line('<h2>Table : '.$req->get('table').'</h2>');
if($is_view) {
	$body->line('This is a view and individual data cannot be altered.<br />');
}

if(!$is_view) {
	$link = new Link;
	$link->setHref('controller.php?cmd=record_add&amp;table='.$req->get('table'));
	$link->setClas('butter');
	$link->setName('Add record');

	$body->line($link->dump());
}

$body->line('<hr>');

$odd = FALSE;
if(!$res) {
	$body->line('Table does not contain records');
} else {
	
	$firstlink = new Link;
	if($is_view) {
		$firstlink->setHref('controller.php?cmd=table_browse&amp;table='.$req->get('table').'&amp;direction=first&view=true');
	} else {
		$firstlink->setHref('controller.php?cmd=table_browse&amp;table='.$req->get('table').'&amp;direction=first');
	}	
	$firstlink->setName('[&lt;&lt;--]');
	$firstlink->build();
	
	$previous = new Link;
	if($is_view) {
		$previous->setHref('controller.php?cmd=table_browse&amp;table='.$req->get('table').'&amp;direction=previous&view=true');
	} else {
		$previous->setHref('controller.php?cmd=table_browse&amp;table='.$req->get('table').'&amp;direction=previous');
	}
	$previous->setName('[&lt;]');
	$previous->build();
	
	$next = new Link;
	if($is_view) {
		$next->setHref('controller.php?cmd=table_browse&amp;table='.$req->get('table').'&amp;direction=next&view=true');
	} else {
		$next->setHref('controller.php?cmd=table_browse&amp;table='.$req->get('table').'&amp;direction=next');
	}	
	$next->setName('[&gt;]');
	$next->build();
	
	$lastlink = new Link;
	if($is_view) {
		$lastlink->setHref('controller.php?cmd=table_browse&amp;table='.$req->get('table').'&amp;direction=last&view=true');
	} else {
		$lastlink->setHref('controller.php?cmd=table_browse&amp;table='.$req->get('table').'&amp;direction=last');
	}	
	$lastlink->setName('[--&gt;&gt;]');
	$lastlink->build();
	
	$low = $sessie->getS('bottom') + 1;
	$high = $sessie->getS('bottom') + LIMIT;
	
	if($high > $records) {
		$high = $records;
	}
	
	$body->line(' (total # of records : <b> '
		.$records
		.'</b> -- showing <b>'
		.$low
		.'</b> till <b>'
		.$high
		.'</b>)<br />');
	
	$titles = FALSE;
	
	$table = new Table;
	$table->setClas('result');
	$table->setId('listing');
	$table->build();
	
	foreach($res as $item) {
		/**/
		if(!$titles) {
			$tr = new Th;
			if(!$is_view) {
				$tr->add('edit');
				$tr->add('delete');
			}
			if(!$pk) {
				$tr->add('ROWID');
			}
			// $names = array_keys(get_object_vars($item));
			for($i=0;$i<sizeof($col);++$i) {
				$tr->add($col[$i]);
			}
			$tr->build();
			$titles = TRUE;
		}
		/**/
		$tr = new Tr;
		if($odd) {
		$tr->setGlobalClass('even');
		$odd = FALSE;
		} else {
			$tr->setGlobalClass('odd');
			$odd = TRUE;
		}
		if(!$is_view) {
			$edit = new Link;
			$edit->setHref('controller.php?cmd=edit_record&amp;table='.$req->get('table').'&amp;id='.$item->id);
			$edit->setName('[edit]');
			// $edit->setTarget('edit_del');
		
			$del = new Link;
			$del->setHref('controller.php?cmd=drop_record&amp;table='.$req->get('table').'&amp;id='.$item->id);
			$del->setName('[del]');
			$del->setJs(' onclick="return PSA.really_drop(\'record\');" ');
			
			$tr->add($edit->dump());
			$tr->add($del->dump());
		}
		
		foreach($item as $data) {
			$tr->add(htmlentities($data));
		}
		$tr->build();
	}
	
	unset($table);
}

$body->line('</div>');
include_once('./inc/footer.php');
unset($body);
unset($html);
