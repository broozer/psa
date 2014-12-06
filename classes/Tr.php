<?php

/**
* [type] file
* [name] Tr.php
* [package] Web
* [author] Wim Paulussen
*/

class Tr extends Base
{
	
	private $_array;
	private $_pointer = 0;
	private $_globalClass = '';
	private $_tbodyId = '';
	
	public function __construct()
	{
		try
		{
			if(!Page::$html_set || !Page::$head_set || !Page::$body_set )
			{
				throw new PageException("<b>Tr class exception.</b><br />Either &lt;html&gt; or &lt;head&gt; or &lt;body&gt; is not set.</b><br />
					All these tags need to be set in this order to generate valid html forms.");
			}
			if(!Table::$table_set)
			{
				throw new PageException("<b>Tr class exception.</b><br />Table line (tr) set without &lt;table&gt; set.<br />");
			}
		}
		catch(PageException $e)
		{
			echo $e->getMessage();
		}
	}
	
	function add($name='')
	{
		try
		{
			
			if ($name == '')
			{
				$name = '&nbsp;';
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
	
	function build()
	{
		if (!Table::$tbody_set)
		{
			$this->html = '<tbody';
			if($this->_tbodyId != '') {
				$this->html .= ' id="'.$this->_tbodyId.'"';
			}
			$this->html .= ">";
			Table::$tbody_set = TRUE;
		}
		if($this->_globalClass == '') {
			$this->html .= "<tr>";
		} else {
			$this->html .= '<tr class="'.$this->_globalClass.'">';
		}
		
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
	
	public function setGlobalClass($data) {
		$this->_globalClass = $data;
	}
	
	public function setTbodyId($data) {
		$this->_tbodyId = $data;
	}
	
}