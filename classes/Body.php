<?php

/**
* [type] file
* [name] Body.php
* [package] Web
* [author] Wim Paulussen
* [since] 2006-12-22
* [update] 2007-01-05 : removed __destruct , replaced by close
* [update] 2007-05-21 : documentation
* [update] 2008-08-17 : new load
* [update] 2009-01-18 : Exception included - checker out
* [update] 2009-07-31 : cleanup
* [todo] body->line = UTF8_decode
*/

/**
* [name] Body
* [type] class
* [extend] Web
*/

class Body extends Web
{
	/**
	* [name] __construct
	* [type] method
	* [scope] public
	* [expl] check html and head are set
	*/
	public function __construct()
	{
		try
		{
			if(!Html::getHtml_set())
			{
				throw new WebException("<b>Body class exception</b><br />Html tag is not yet defined.</b><br> 
				  Please define &lt;html&gt; tag first.");
			}
			if(!Html::getHead_set())
			{
				throw new WebException("<b>Body class exception</b><br />Head tag is not yet defined.</b><br> 
				  Please define &lt;head&gt; tag first.");
			}
		}
		catch(WebException $e)
		{
			echo $e->getMessage();
		}
		Html::$body_set = TRUE;
	}
	/**
	* [name] build
	* [type] method
	* [scope] public
	* [expl] after all tags are set , you run this function
	*/
	public function build()
	{
		$this->html = '<body ';
		
		if ($this->id != '')
		{
			$this->html .= ' id="'.$this->getId().'" ';
		}
		
		if ($this->js != '')
		{
			$this->html .= $this->getJs();
		}
		
		$this->html .= ">\n";

		$this->display();
	}
	
	/**
	* [name] line
	* [type] method
	* [scope] public
	* [expl] echo function for direct html input
	* [expl] will return a CRLF if no argument is given
	*/
	public function line()
	{
		try
		{
			$numargs	= func_num_args();
			if ($numargs > 0)
			{
				$this->html = func_get_arg(0)."\n";
			}
			else
			{
				$this->html = "<br />\n";
			}
			
			$this->display();
		}
		catch(WebException $e)
		{
			echo $e->getMessage();
		}
	}
}

?>