<?php

/**
 * [type] file
 * [name] ./action/ajax_delete_field.php
 * [package] psa
 * [since]
 */
 
include_once('loader.php');

// validate received data
$ajax_sql = new LitePDO('sqlite:../data/base.sqlite');

$q = "DELETE FROM temp_table_fields WHERE id = ".$req->get('field')." ";

$ajax_sql->qo($q);

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

if(!$res) {
	$tab .= '</tbody></table>';
} else {
	foreach ($res as $item) {
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
}
echo $tab;