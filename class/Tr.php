<?php

/*
** [type] file
** [name] Tr.php
** [author] Wim Paulussen
** [since] 2007-01-05
** [update] 2007-05-21 added new functionality for getId and getClas (needs testing)
** [todo] documentation (partly)
** [end]
*/

/*
** [class] Tr
** [extend] Table
** [extend] Body
** [extend] Html
** [extend] Session
** [end]
*/

class Tr extends Table
{
	/* 
	** [type] attribute
	** [name] _array
	** [scope] private
	** [expl] array for tr elements
	** [end]
	*/
	private $_array;

	/* 
	** [type] attribute
	** [name] _pointer
	** [scope] private
	** [expl] holds last number for array starting value is 0
	** [end]
	*/
	private $_pointer = 0;

	/*
	** [type] method
	** [name] addElement
	** [scope] public
	** [expl] adds the thead elements in an array
	** [expl] expects 3 parameters 
	** [expl] par1 : name to be displayed
	** [expl] par2 : id name for rendering
	** [expl] par3 : class name for rendering, positioning (needs to be set in css)
	** [end]
	*/
	function addElement($name)
	{
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
	
	/*
	** [type] method
	** [name] build
	** [scope] public
	** [expl] after all tags are set , you run this function
	** [end]
	*/
	function build()
	{
		$this->html = "<tr>";
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
			$this->html .='>'.$this->_array[$i]['name']."</td>";
		}
		$this->html .= "</tr>\n";
		$this->display();
	}
}
?>
