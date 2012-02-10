<?php

/**
* [name] Table.php
* [type] file
* [package] Page
* [author] Wim Paulussen
*/

class Table extends Base
{
	
	private $_length = '99';
	public static $table_set = FALSE;
	public static $tbody_set = FALSE;
	public $cols = Array();

	public function __construct() {
		try
		{
			if(!Page::$html_set || !Page::$head_set || !Page::$body_set )
			{
				throw new PageException("<b>Table class exception.</b><br />Either &lt;html&gt; or &lt;head&gt; or &lt;body&gt; is not set.</b><br />
					All these tags need to be set in this order to generate valid html forms.");
			}
		}
		catch(PageException $e)
		{
			echo $e->getMessage();
		}
		self::$table_set = TRUE;
	}
	
	public function setLength($data) { $this->_length	= $data; }
	public function setName($data) { $this->name	= $data; }
	public function setCol($data) { $this->cols[]	= $data; }
	
	public function getName() { return $this->name; }
	private function getLength() { return $this->_length; }

	function build() {
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
		if(sizeof($this->cols) != 0) {
			for($i=0;$i<sizeof($this->cols);++$i) {
				$this->html .= '<col width="'.$this->cols[$i].'">';
			}
		} 
		$this->display();
	}
	
	function __destruct()
	{
		$this->html = "</tbody></table>";
		self::$tbody_set = FALSE;
		$this->display();
	}
	
}

?>
