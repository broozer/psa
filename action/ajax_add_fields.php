<?php

include_once('loader.php');

// $req->dump();
// validate received data
$ajax_sql = new LitePDO('sqlite:../data/base.sqlite');

$error = FALSE;
$errmsg = '';

// tblname not blank
if($req->get('tblname') === '') {
	$error = true;
	$errmsg = 'oeps - Table name may not be blank';
}

// colname not blank
if(!$error) {
	if($req->get('colname') === '') {
		$error = 'true';
		$errmsg = 'oeps - Column name may not be blank';
		
	} 
}
// no columns with same name
if(!$error) {
	$q = "SELECT colname FROM temp_table_fields WHERE colname = '".$req->get('colname')."' ";
	// echo $q;
	$ajax_sql->qo($q);
	$res = $ajax_sql->fo_one();
	//var_dump($res);
	if(!$res) {
		// void - no duplication
	} else {
		$errmsg = 'oeps - Name already exists';
		$error = true;
	}
}

// no double primary key
if(!$error) {
	// check if colprime already set , if so -> warning
	if($req->get('colprime') === "1") {
		$q = "SELECT id FROM temp_table_fields WHERE colprime > 0";
		// echo $q;
		$ajax_sql->qo($q);
		$res = $ajax_sql->fo_one();
		//var_dump($res);
		if(!$res) {
			// void - no colprime set
		} else {
			$errmsg = 'oeps - Only 1 primary column allowed';
			$error = true;
			
		}
	}
}

if(!$error) {
	// finally , everything is ok and ready for processing
	$q = "DELETE FROM temp_table_fields WHERE tblname <> '".$req->get('tblname')."' ";
	// $q = "INSERT INTO temp_table_fields (tblname) VALUES ('xxx')";
	$ajax_sql->qo($q);
	// var_dump($ajax_sql);
	
	$tblname = $req->get('tblname');
	$colname = $req->get('colname');
	$coltype = $req->get('coltype');
	$colprime = $req->get('colprime');
	$colnull = $req->get('colnull');
	$colsize = $req->get('colsize');
	$coldefault = $req->get('coldefault');

	
	$q = "INSERT INTO temp_table_fields (
		tblname
		,colname
		,coltype
		,colprime
		,colnull
		,colsize
		,coldefault)
		VALUES (
		:tblname
		,:colname
		,:coltype
		,:colprime
		,:colnull
		,:colsize
		,:coldefault)";
	
	$ajax_sql->binder('tblname',$tblname);
	$ajax_sql->binder('colname',$colname);
	$ajax_sql->binder('colprime',$colprime);
	$ajax_sql->binder('coltype',$coltype);
	$ajax_sql->binder('colnull',$colnull);
	$ajax_sql->binder('colsize',$colsize);
	$ajax_sql->binder('coldefault',$coldefault);
	
	$ajax_sql->qo($q);
	// DEBUG: var_dump($ajax_sql);

	$q = "SELECT * FROM temp_table_fields";
	$ajax_sql->qo($q);
	$res = $ajax_sql->fo();

	$tab = '<table>';
	$tab .= '<thead>
		<th>name</th>
		<th>type</th>
		<th>size</th>
		<th>prime</th>
		<th>null</th>
		<th>default</th>
		</thead><tbody>';
	
	foreach($res as $item) {
		$tab .= '
			<tr><td>'.$item->colname.
			'</td><td>'.$item->coltype.
			'</td><td>'.$item->colsize.
			'</td><td>'.$item->colprime.
			'</td><td>'.$item->colnull.
			'</td><td>'.$item->coldefault.
			'</td><td><a href="#" onclick="PSA.tablerow_delete('.$item->id.');"><button>delete</button></a>'.
			'</td></tr>';
	}
	$tab .= '</tbody></table>';
	echo $tab;
} else {
	echo $errmsg;
}
	
?>