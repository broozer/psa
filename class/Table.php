<?php

/*
** [type] file
** [name] Table.php
** [author] Wim Paulussen
** [since] 2006-12-27
** [update] 2007-01-05 - removed __destruct , replaced by close
** [todo] ALL
** [end]
*/

/*
** [class] Table
** [extend] Body
** [extend] Html
** [extend] Session
** [end]
*/
class Table extends Body
{
	/* 
	** [type] attribute
	** [name] _length
	** [scope] private
	** [expl] set table span , standard 99
	** [end]
	*/
	private $_length = '99';

	/*
	** [type] method
	** [name] setLength
	** [scope] public
	** [expl] set table width
	** [end]
	*/
	public function setLength($data) { $this->_length	= $data; }

	/*
	** [type] method
	** [name] build
	** [scope] public
	** [expl] after all tags are set , you run this function
	** [end]
	*/
	function build()
	{
		$this->html = '<table summary="'
			.$this->getName()
			.'" width="'
			.$this->_length.'"';
			if ($this->id != '')
			{
				$this->html .= ' id="'.$this->id.'" ';
			}
			$this->html .= '>'
			."\n";
		$this->display();
	}
	
	/*
	** [type] method
	** [name] close
	** [scope] global
	** [expl] ends the table with table tag
	** [end]
	*/
	function close()
	{
		$this->html = "</table>";
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