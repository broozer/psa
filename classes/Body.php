<?php

/**
* [type] file
* [name] Body.php
*/

class Body extends Base
{
	public function __construct()
	{
		try
		{
			if(!Page::getHtml_set())
			{
				throw new WebException("<b>Body class exception</b><br />Html tag is not yet defined.</b><br> 
				  Please define &lt;html&gt; tag first.");
			}
			if(!Page::getHead_set())
			{
				throw new WebException("<b>Body class exception</b><br />Head tag is not yet defined.</b><br> 
				  Please define &lt;head&gt; tag first.");
			}
		}
		catch(WebException $e)
		{
			echo $e->getMessage();
		}
		Page::$body_set = TRUE;
	}
	
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
				$this->html = "<br>\n";
			}

			$this->html = utf8_encode($this->html);
			
			$this->display();
		}
		catch(PageException $e)
		{
			echo $e->getMessage();
		}
	}
}
