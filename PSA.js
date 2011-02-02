/* PSA.js */
var PSA = {

	to_text: function(data)
	{
		/* TODO : clean up data (newlines etc) */
		/* when queries include "'" the link does not work -> I replace the "'" to "##"
		and revert it back here 
		*/
		data = data.replace(/##/g,"'");
		var cop = document.getElementById('to_text');
		cop.innerHTML = data;
	},

	really_drop: function(data) {
		var answer = confirm('Really drop ' + data + ' ?');
		if(!answer) {
			return false;
		}
		return true;
	},

	/*
	really_drop_record: function(data) {
		var answer = confirm('Really drop ' + data + ' ?');
		if(!answer) {
			return false;
		}
		
		return true;
	}
	*/
}