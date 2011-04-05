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
		var colname = PSA.getId('colname').value;
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
		var checktxt = 'colname : ' + colname + "\r\n";
		checktxt = checktxt + 'coltype : '+ coltype + "\r\n";
		checktxt = checktxt + 'colprime : '+ colprime + "\r\n";
		checktxt = checktxt + 'colsize : '+ colsize + "\r\n";
		checktxt = checktxt + 'colnull : '+ colnull + "\r\n";
		checktxt = checktxt + 'coldefault : '+ coldefault + "\r\n";
		alert(checktxt);
		
		var fields = 'colname=' + colname;
		fields = fields + '&coltype=' + coltype;
		fields = fields + '&colprime=' + colprime;
		fields = fields + '&colsize=' + colsize;
		fields = fields + '&colnull=' + colnull;
		fields = fields + '&coldefault=' + coldefault;
		
		this.xmlhttp.open("GET", './action/ajax_add_fields.php?' + fields, false);
		this.xmlhttp.send(null);
		
	},
	/*
		this.xmlhttp.open("GET", './action/checkvies.php?btw=' + btw.value, false);
		this.xmlhttp.send(null);
		
	*/
	
	to_text: function (data) {
		/* TODO : clean up data (newlines etc) */
		/* when queries include "'" the link does not work -> I replace the "'" to "##"
		and revert it back here 
		*/
		data = data.replace(/##/g, "'");
		var cop = document.getElementById('to_text');
		cop.innerHTML = data;
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