<?php

/**
* [name] Table.php
* [type] file
* [package] Web
* [author] Wim Paulussen
* [since] 2006-12-27
* [update] 2007-01-05 : removed __destruct , replaced by close
* [update] 2007-09-27 : Exception handling added
* [update] 2007-12-02 : setId en setClas toegevoegd
* [update] 2009-08-12 : E_STRICT compliant
*/

/**
* [class] Table
* [extend] Web
*/
class Table extends Web
{
	/**
	* [name] _length
	* [type] attribute
	* [scope] private
	* [expl] set table span , standard 99
	* [end]
	*/
	private $_length = '99';

	/** 
	* [type] attribute
	* [name] table_set
	* [scope] public static
	* [expl] will be set with table contruct
	*/
	public static $table_set = FALSE;
	
	/** 
	* [type] attribute
	* [name] tbody_set
	* [scope] public static
	* [expl] will be set to true if first row in TR is called
	*/
	public static $tbody_set = FALSE;
	
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
				throw new WebException("<b>Table class exception.</b><br />Either &lt;html&gt; or &lt;head&gt; or &lt;body&gt; is not set.</b><br />
					All these tags need to be set in this order to generate valid html forms.");
			}
		}
		catch(WebException $e)
		{
			echo $e->getMessage();
		}
		self::$table_set = TRUE;
	}
	/**
	* [name] setLength
	* [type] method
	* [scope] public
	* [expl] set table width
	*/
	public function setLength($data) { $this->_length	= $data; }
	/**
	* [name] getLength
	* [type] method
	* [scope] public
	* [expl] get table width
	*/
	private function getLength() { return $this->_length; }

	/**
	* [type] method
	* [name] setName
	* [scope] public
	* [expl] set table name
	*/
	public function setName($data) { $this->name	= $data; }
	
	/**
	* [type] method
	* [name] getName
	* [scope] public
	* [expl] get table name
	*/
	public function getName() { return $this->name; }
	
	/**
	* [type] method
	* [name] build
	* [scope] public
	* [expl] after all tags are set , you run this function
	*/
	function build()
	{

		$this->html = '<table'; 
		if($this->getName() != '')
		{

			$this->html .=' summary="'.$this->getName().'"';
		}
		if($this->getLength() != '99')
		{
			$this->html .=' width="'.$this->_length.'"';
		}
		if ($this->getId() != '')
		{
			$this->html .= ' id="'.$this->getId().'" ';
		}
		if ($this->getClas() != '')
		{
			$this->html .= ' class="'.$this->getClas().'" ';
		}
		$this->html .= '>';
		$this->display();
	}
	
	/**
	* [type] method
	* [name] __destruct
	* [scope] global
	* [expl] ends the table with table tag
	*/
	function __destruct()
	{
		$this->html = "</tbody></table>";
		self::$tbody_set = FALSE;
		$this->display();
	}
	
	/* bijwerken indien gebruikt
	function setCols($length)
	{
		if ($length == '')
		{
			$this->error("length  NOT set in setCols.");
			return FALSE;
		}
		
		if (isset($this->arCols))
		{
			$this->pointerCols	= sizeof($this->arCols);
		}
		$this->arCols[$this->pointerCols]= $name;
		return TRUE;
		
		// html
		$toHtml = $toHtml.'<col width="'.$this->name.'" />'."\n";
	}
	*/
}

?>
