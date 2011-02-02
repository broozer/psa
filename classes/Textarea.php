<?php

/**
* [type] file
* [name] Textarea.php
* [package] Web
* [author] Wim Paulussen
* [since] 2006-12-22
* [update] 2009-01-22 : exception
* [update] 2009-02-27 : __construct may happen outside html tags
*/

/**
* [name] Textarea
* [type] class
* [extend] Body
*/
class Textarea extends Web
{
	private $values = '';
	private $rows	= '3';
	private $cols = '60';
	private $readonly = FALSE;

	function setValue($data) { $this->values = $data; }
	function setRows($data) { $this->rows = $data; }
	function setCols($data) { $this->cols = $data; }
	function setReadonly() { $this->readonly = TRUE; }

	/**
	* [name] __construct
	* [type] method
	* [scope] public
	* [expl] checks for html-head-body
	*/
	public function __construct()
	{
		// void
	}
	/**
	* [name] build
	* [type] method
	* [scope] public
	* [expl] display built string
	*/
	public function build()
	{
		$this->_prepare();
		$this->display();
	}
	
	/**
	* [type] method
	* [name] dump
	* [scope] public
	* [expl] returns the html-string instead of printing it
	*/
	public function dump()
	{
		$this->_prepare();
		return $this->html;
	}
	
	/**
	* [type] method
	* [name] _prepare
	* [scope] private
	* [expl] 
	*/
	function _prepare()
	{
		try
		{

			if(!HTML::$html_set || !HTML::$head_set || !HTML::$body_set )
			{
				throw new WebException("<b>Textarea class exception.</b><br />Either &lt;html&gt; or &lt;head&gt; or &lt;body&gt; is not set.</b><br />
					All these tags need to be set in this order to generate valid html forms.");
			}
		
			if ($this->getName() == '')
			{
				throw new WebException("<b>Textarea class exception.</b><br />Name is not set.");
			}
	
			$this->html	 = '<textarea name="';
			$this->html	.= $this->getName();
			$this->html	.= '" rows="';
			$this->html	.=$this->rows;
			$this->html	.='" cols="';
			$this->html	.=$this->cols;
			$this->html	.= '"';
	
			if ($this->readonly)
			{
				$this->html .= " readonly ";
	
			}
	
			if ($this->id != '')
			{
				$this->html .= ' id="'.$this->getId().'"';
	
			}
	
			$this->html	.= '>'.$this->values.'</textarea>';
	
			return $this->html;
		}
		catch(WebException $e)
		{
			echo $e->getMessage();
		}
	}
}



?>
