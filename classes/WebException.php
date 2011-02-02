<?php

/**
* [name] WebException
* [type] class
* [extend] Exception
*/
class WebException extends Exception
{
	/** 
	* [type] method
	* [name] __construct
	* [scope] global
	* [expl] exception function for package Common
	*/
	function __construct($eMessage)
	{
		// ob_end_clean();
		parent::__construct('<div style="color: midnightblue; background-color: orange;"><hr />'.$eMessage.'<hr /></div>');
	}
	
}

?>
