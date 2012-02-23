/* PSA.js */
/* jslint : 2011.02.23 */
/*jslint white: true, onevar: true, undef: true, newcap: 
true, nomen: true, regexp: true, plusplus: true, bitwise: true, 
browser: true, devel: true, maxerr: 50, indent: 4 */

var PSA = {

	xmlhttp: '',
	
	init: function() {
		/* alert('BTW.js loaded'); */
		
		if (window.XMLHttpRequest)
		{
			this.xmlhttp = new XMLHttpRequest();
		}
		else
		{
			this.xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
		}
	},
	
	getId: function(data) {
		var fieldid = document.getElementById(data);
		return fieldid;
	},
	
	/* table_add get field content and add it */
	addField: function() {
		var err_check = '';
		var tblname = PSA.getId('tblname').value;
		if(tblname === '') {
			err_check = err_check + "Table name needs to be filled in \r\n";
		}
			
		var colname = PSA.getId('colname').value;
		if(colname === '') {
			err_check = err_check + "Column name needs to be filled in \r\n";
		} 
		
		var coltypesel = PSA.getId('coltype');
		var coltypepos = coltypesel.selectedIndex;
		var coltype = coltypesel[coltypepos].value;
		var colprime = 0;
		var colprimecheck = PSA.getId('colprime');
		
		if(colprimecheck.checked) {
			colprime = 1;
		}
		var colsize = PSA.getId('colsize').value;
		var colnull = 0;
		var colnullcheck = PSA.getId('colnull');
		
		if(colnullcheck.checked) {
			colnull = 1;
		}
		var coldefault = PSA.getId('coldefault').value;
		// var col = PSA.getId('col').value;
		/*
			var checktxt = 'colname : ' + colname + "\r\n";
			checktxt = checktxt + 'coltype : '+ coltype + "\r\n";
			checktxt = checktxt + 'colprime : '+ colprime + "\r\n";
			checktxt = checktxt + 'colsize : '+ colsize + "\r\n";
			checktxt = checktxt + 'colnull : '+ colnull + "\r\n";
			checktxt = checktxt + 'coldefault : '+ coldefault + "\r\n";
			alert(checktxt);
			*/

		if(err_check !== '') {
			alert(err_check);
		} else {
			var fields = '&tblname=' + tblname;
			fields = fields + '&colname=' + colname;
			fields = fields + '&coltype=' + coltype;
			fields = fields + '&colprime=' + colprime;
			fields = fields + '&colsize=' + colsize;
			fields = fields + '&colnull=' + colnull;
			fields = fields + '&coldefault=' + coldefault;
	
			if (window.XMLHttpRequest)
			{
				xmlhttp = new XMLHttpRequest();
			}
			else
			{
				xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
			}
			
			xmlhttp.open("GET", './action/ajax_add_fields.php?fields=' + fields, false);
	
			xmlhttp.onreadystatechange = function() {
			
				if(xmlhttp.readyState == 4)	{
					var calform = xmlhttp.responseText;
					var ttshow = PSA.getId('ttshow');
				
					ttshow.innerHTML = calform;
					
					var colname = PSA.getId('colname');
					colname.value = '';
					var colprime = PSA.getId('colprime');
					colprime.checked = false;

					var colsize = PSA.getId('colsize');
					colsize.value = '';

					var colnull = PSA.getId('colnull');
					colnull.checked = false;
					/* colnull.checked = false; */
					var coldefault = PSA.getId('coldefault');
					coldefault.value = '';
				}
				
			} 
			xmlhttp.send(null);
		}
	},

	tablerow_delete: function(id) {
		// alert('about to delete : ' + id);
		if (window.XMLHttpRequest) {
				xmlhttp = new XMLHttpRequest();
		}
		else
		{
			xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
		}
			
		xmlhttp.open("GET", './action/ajax_delete_field.php?field=' + id, false);
	
		xmlhttp.onreadystatechange = function() {
			
			if(xmlhttp.readyState == 4)	{
				var calform = xmlhttp.responseText;
				var ttshow = PSA.getId('ttshow');
				ttshow.innerHTML = calform;
			}
			
		}
		xmlhttp.send(null);
		
	},

	indexcol: function() {
		var idxname = document.getElementById('idxname').value;
		idxname.replace(/^\s+|\s+$/g,"");
		if(idxname === '') {

			alert('Please fill in index name !');
			return false;
		}
		return true;
	},
	
	to_text: function (data) {
		/* TODO : clean up data (newlines etc) */
		/* 
		when queries include "'" or '"' the link does not work 
			-> I replace the "'" to "##" and the '"' to "&&"
			and revert it back here 
		*/
		data = data.replace(/##/g, "'");
		data = data.replace(/&&/g, '"');
		var cop = document.getElementById('to_text');
		cop.innerHTML = data;
	},

	menutoggle: function() {
		var menutoggle = PSA.getId('menu');
		var menushow = PSA.getId('menushow');
		
		if(menutoggle.style.display == 'none') {
			menutoggle.style.display = 'block';
			menushow.style.display = 'none';
			return false;
		} else {
			menutoggle.style.display = 'none';
			menushow.style.display = 'inline';
			return false;
		}
	},
	
	really_drop: function (data) {
		var answer = confirm('Really drop ' + data + ' ?');
		if (!answer) {
			return false;
		}
		return true;
	}

};

PSA.init();