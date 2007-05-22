<?php

/*
** [type] file
** [name] Select.php
** [author] Wim Paulussen
** [since] 2007-01-17
** [update] 2007-01-23 : double quote after id removed (validator , thanks)
** [update] 2007-01-23 : selected="selected" (validator)
** [update] 2007-05-21 : documentatie - debug
** [todo] All
** [end]
*/

/*
** [class] Select
** [extend] Body
** [extend] Html
** [extend] Session
** [end]
*/
class Select extends Body
{
	/*
	** [type] attribute
	** [name] _size
	** [end]
	*/
	private $_size = 1;
	/*
	** [type] attribute
	** [name] _selected
	** [end]
	*/
	private $_selected = FALSE;
	/*
	** [type] attribute
	** [name] __arOpt
	** [end]
	*/
	private $_arOpt;
	/*
	** [type] attribute
	** [name] _pointerOpt
	** [end]
	*/
	private $_pointerOpt;
	/*
	** [type] attribute
	** [name] _option
	** [end]
	*/
	private $_option;
	/*
	** [type] method
	** [name] __construct
	** [scope] global
	** [expl] 
	** [end]
	*/
	function __construct()
	{
		$this->_arOpt = array();
		$this->_option = '';
	}
	
	/*
	** [type] method
	** [name] setSize
	** [scope] 
	** [expl] 
	** [end]
	*/
	function setSize($data) {$this->_size = $data; }
	/*
	** [type] method
	** [name] setSelected
	** [scope] 
	** [expl] 
	** [end]
	*/
	function setSelected($data) {$this->_selected = $data; }
	/*
	** [type] method
	** [name] addElement
	** [scope] 
	** [expl] 
	** [end]
	*/
	function addElement($value,$text,$selected=FALSE)
	{
		$this->_pointerOpt = sizeof($this->_arOpt);
		$this->_arOpt[$this->_pointerOpt]['value']	= $value;
		$this->_arOpt[$this->_pointerOpt]['text']	= $text;
		if($value == $this->_selected)
		{
			$selected = TRUE;
		}
		$this->_arOpt[$this->_pointerOpt]['selected'] = $selected;
	}
	
	/*
	** [type] method
	** [name] getSize
	** [scope] 
	** [expl] 
	** [end]
	*/
	function getSize() { return $this->_size; }
	/*
	** [type] method
	** [name] returnArOpt
	** [scope] 
	** [expl] 
	** [end]
	*/
	function returnArOpt() { return $this->_arOpt; }
	/**
	changOpt	-> verandert een waarde binnen de array (om bvb nadien selected te bepalen
		parameter $k	: positie in de array
		rest werkt als setOpt
	*/
	/*
	** [type] method
	** [name] changeOpt
	** [scope] 
	** [expl] 
	** [end]
	*/
	function changeOpt($k,$value,$text,$selected=FALSE)
	{
		$this->_arOpt[$k]['value'] = $value;
		$this->_arOpt[$k]['text']	= $text;
		$this->_arOpt[$k]['selected'] = $selected;
	}
	
	/*
	** [type] method
	** [name] build
	** [scope] public
	** [expl] 
	** [end]
	*/
	public function build()
	{
		$this->error = '';
		
		if ($this->getName() == '')
		{
			$this->error = "Geen waarde gezet voor het veld naam in select(verplicht).<br>";
		}

		if(sizeof($this->_arOpt) == "0")
		{
   			$this->error = "Er zijn geen waarden voor selectie gekozen.";
		}

		if ($this->error == "")
		{
			$toHtml = '<select name="'
				.$this->getName().'" size="'.$this->getSize().'" ';

			if($this->getId() != '')
			{
				$toHtml .= ' id="'.$this->getId().'" ';
			}

			$toHtml .='>'."\n";
			
			for($i=0;$i<sizeof($this->_arOpt);++$i)
			{
				$this->waarde	= $this->_arOpt[$i]['value'];
				$this->tektest	= $this->_arOpt[$i]['text'];

				if ($this->_arOpt[$i]['selected'])
				{
					$this->_option .= '<option selected="selected" value="'
						.$this->waarde
						.'">'
						.$this->tektest
						.'</option>'."\n";
				}
				else
				{
					$this->_option .= '<option value="'
						.$this->waarde
						.'">'
						.$this->tektest
						.'</option>'."\n";
				}
			}

			$endHtml = "</select>\n";

			$this->html = $toHtml.$this->_option.$endHtml;
			
			return $this->html;
			
		}
		else
		{
			$this->setS('s_error',$this->error);
		}
	}
	
}

?>