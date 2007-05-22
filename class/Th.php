<?php

/*
** [type] file
** [name] Th.php
** [author] Wim Paulussen
** [since] 2007-01-02
** [update] 2007-05-22 : update for Id and Class , changed extend to Body
** [todo] colset
** [end]
*/

/*
** [class] Th
** [extend] Table
** [extend] Body
** [extend] Html
** [extend] Session
** [end]
*/

class Th extends Body
{
	/* 
	** [var] _pointerTh
	** [scope] private
	** [expl] holds last number for array starting value is 0
	** [end]
	*/
	private $_pointerTh = 0;

	/* 
	** [var] _arTh
	** [scope] private
	** [expl] array for thead elements
	** [end]
	*/
	private $_arTh;

	/*
	** [function] addElement
	** [scope] public
	** [expl] adds the thead elements in an array
	** [expl] expects 2 parameters 
	** [expl] par1 : name to be displayed
	** [expl] par2 : class id for rendering, positioning (needs to be set in css)
	** [end]
	*/
	public function addElement($data)
	{
		if ($data == '')
		{
			$this->error("data NOT set in addElement.");
			return FALSE;
		}
		
		if (isset($this->_arTh))
		{
			$this->_pointerTh	= sizeof($this->_arTh);
		}
		$this->_arTh[$this->_pointerTh]['name'] 	= $data;
		return TRUE;
	}
	
	/*
	** [function] build
	** [scope] public
	** [expl] after all tags are set , you run this function
	** [end]
	*/
	public function build()
	{
		$this->html	= "<tr>";
		for($i=0;$i<sizeof($this->_arTh);++$i)
		{
			$this->html	 .= "<th";
			if($this->id != '')
			{
				$this->html .= ' id="'.$this->getId().'" ';
				$this->setId('');
			}
			if($this->clas != '')
			{
				$this->html .= ' class="'.$this->getClas().'" ';
				$this->setClas('');
			}
			$this->html	 .= ">".$this->_arTh[$i]['name'].'</th>';
		}
		$this->html	 .= "</tr>\n";
		$this->display();
	}

}