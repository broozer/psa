<?php

/**
* [type] file
* [name] Tr.php
* [package] Web
* [author] Wim Paulussen
* [since] 2007-01-05
* [update] 2007-05-21 added new functionality for getId and getClas (needs testing)
* [update] 2009-01-22 : exception
* [update] 2009-10-08 : display with <eol> (\r\n)
* [todo] documentation (partly)
*/

/**
* [name] Tr
* [type] class
* [extend] Web
*/

class Tr extends Web
{
	/**
	* [type] attribute
	* [name] _array
	* [scope] private
	* [expl] array for tr elements
	*/
	private $_array;

	/**
	* [type] attribute
	* [name] _pointer
	* [scope] private
	* [expl] holds last number for array starting value is 0
	*/
	private $_pointer = 0;

	/**
	* [name] __construct
	* [type] method
	* [scope] public
	* [expl] checks for html-head-body
	*/
	public function __construct()
	{
		try
		{
			if(!HTML::$html_set || !HTML::$head_set || !HTML::$body_set )
			{
				throw new WebException("<b>Tr class exception.</b><br />Either &lt;html&gt; or &lt;head&gt; or &lt;body&gt; is not set.</b><br />
					All these tags need to be set in this order to generate valid html forms.");
			}
			if(!Table::$table_set)
			{
				throw new WebException("<b>Tr class exception.</b><br />Table line (tr) set without &lt;table&gt; set.<br />");
			}
		}
		catch(WebException $e)
		{
			echo $e->getMessage();
		}
	}
	
	/**
	* [type] method
	* [name] addElement
	* [scope] public
	* [expl] adds elements in an array
	* [expl] expects 1 parameter
	*/
	function addElement($name='')
	{
		try
		{
			
			if ($name == '')
			{
				// 2010.09.23 : empty fields in db possible
				$name = '&nbsp;';
				// throw new WebException("<b>Tr class exception</b><br />AddElement without data.");
			}
			$this->_pointer = sizeof($this->_array);
			$this->_array[$this->_pointer]['name']	= $name;
			if ($this->getId() != '')
			{
				$this->_array[$this->_pointer]['id']	= $this->getId();
			}
			if ($this->getClas() != '')
			{
				$this->_array[$this->_pointer]['class']	= $this->getClas();
			}
			$this->setClas('');
			$this->setId('');
		}
		catch(WebException $e)
		{
			echo $e->getMessage();
		}
	}
	
	/**
	* [type] method
	* [name] build
	* [scope] public
	* [expl] after all tags are set , you run this function
	*/
	function build()
	{
		if (!Table::$tbody_set)
		{
			$this->html = '<tbody>';
			Table::$tbody_set = TRUE;
		}
		$this->html .= "<tr>";
		for($i=0;$i<sizeof($this->_array);++$i)
		{
			$this->html .= '<td';
			if (isset($this->_array[$i]['id']))
			{
				$this->html .= ' id="'.$this->_array[$i]['id'].'"';
			}
			if (isset($this->_array[$i]['class']))
			{
				$this->html .= ' class="'.$this->_array[$i]['class'].'"';
					
			}
			if(trim($this->_array[$i]['name']) == '') {
				$this->_array[$i]['name'] = '&nbsp;';
			}
			$this->html .='>'.$this->_array[$i]['name']."</td>";
		}
		$this->html .= "</tr>"."\r\n";
		$this->display();
	}
}
?>
