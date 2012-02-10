<?php


class PageException extends Exception {

	function __construct($eMessage)
	{
		// ob_end_clean();
		parent::__construct('<div style="color: midnightblue; background-color: orange;"><hr />'.$eMessage.'<hr /></div>');
	}
	
}

?>
