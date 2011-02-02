<?php

/**
* [type] file
* [name] Th.php
* [package] Web
* [author] Wim Paulussen
* [since] 2007-01-02
* [update] 2007-05-22 : update for Id and Class , changed extend to Body
* [update] 2007-11-29 : error function reset to setS
* [update] 2009-01-22 : exception
* [todo] colset
*/

/**
* [name] Th
* [type] class
* [extend] Web
*/

class Th extends Web
{
	/** 
	* [name] _pointerTh
	* [type] attribute
	* [scope] private
	* [expl] holds last number for array starting value is 0
	*/
	private $_pointerTh = 0;

	/** 
	* [name] _arTh
	* [type] attribute
	* [scope] private
	* [expl] array for thead elements
	*/
	private $_arTh;

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
				throw new WebException("<b>Th class exception</b><br />Either &lt;html&gt; or &lt;head&gt; or &lt;body&gt; is not set.</b><br />
					All these tags need to be set in this order to generate valid html forms.");
			}
			if(!Table::$table_set)
			{
				throw new WebException("<b>Th class exception.</b><br />Table line (th) set without &lt;table&gt; set.<br />");
			}
		}
		catch(WebException $e)
		{
			echo $e->getMessage();
		}
	}
	/**
	* [name] addElement
	* [type] method
	* [scope] public
	* [expl] adds the thead elements in an array
	* [expl] expects 1 parameter 
	* [expl] par1 : name to be displayed
	* [expl] if you want to add a 'class' tag, use $th->setClas('&lt;name of class&gt;>);
	*/
	public function addElement($data='')
	{
		try
		{
			
			if ($data == '')
			{
				throw new WebException("<b>Th class exception</b><br />AddElement without data.");
			}
			
			if (isset($this->_arTh))
			{
				$this->_pointerTh	= sizeof($this->_arTh);
			}
			$this->_arTh[$this->_pointerTh]['name'] 	= $data;
			if ($this->clas != '')
			{
				$this->_arTh[$this->_pointerTh]['class'] = $this->getClas();
			}
			return TRUE;
		}
		catch(WebException $e)
		{
			echo $e->getMessage();
		}
	}
	/**
	* [name] build
	* [type] method
	* [expl] after all tags are set , you run this function
	*/
	public function build()
	{
		$this->html	= "<thead><tr>";
		for($i=0;$i<sizeof($this->_arTh);++$i)
		{
			$this->html	 .= "<th";
			if($this->id != '')
			{
				$this->html .= ' id="'.$this->getId().'" ';
				$this->setId('');
			}
			if(isset($this->_arTh[$i]['class']))
			{
				$this->html .= ' class="'.$this->_arTh[$i]['class'].'" ';
				$this->setClas('');
			}
			$this->html	 .= ">".$this->_arTh[$i]['name'].'</th>';
		}
		$this->html	 .= "</tr></thead>"."\r\n";
		$this->display();
	}

}
