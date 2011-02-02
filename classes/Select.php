<?php

/**
* [type] file
* [name] Select.php
* [package] Web
* [author] Wim Paulussen
* [since] 2007-01-17
* [update] 2007-01-23 : double quote after id removed (validator , thanks)
* [update] 2007-01-23 : selected="selected" (validator)
* [update] 2007-05-21 : documentatie - debug
* [update] 2009-01-22 : exception
* [update] 2009-10-20 : double quote after setJs removed
*/

/**
* [name] Select
* [type] class
* [extend] Web
*/
class Select extends Web
{
	/**
	* [type] attribute
	* [name] _size
	*/
	private $_size = 1;
	/**
	* [type] attribute
	* [name] _selected
	*/
	private $_selected = FALSE;
	/**
	* [type] attribute
	* [name] _disabled
	*/
	private $_disabled = FALSE;
	/**
	* [type] attribute
	* [name] __arOpt
	*/
	private $_arOpt = array();
	/**
	* [type] attribute
	* [name] _pointerOpt
	*/
	private $_pointerOpt;
	/**
	* [type] attribute
	* [name] _option
	*/
	private $_option = '';
	/**
	* [type] method
	* [name] __construct
	* [scope] global
	* [expl] 
	*/
	/**
	* [name] __construct
	* [type] method
	* [scope] public
	* [expl] checks for html-head-body
	*/
	public function __construct()
	{
		//void
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
	* [name] setSize
	* [scope] public 
	* [expl] 
	*/
	public function setSize($data) {$this->_size = $data; }
	/**
	* [type] method
	* [name] setSelected
	* [scope] public 
	* [expl] 
	*/
	public function setSelected($data) {$this->_selected = $data; }
	/**
	* [type] method
	* [name] setDisabled
	* [scope] public 
	* [expl]
	*/
	function setDisabled($data) {$this->_disabled = $data; }
	/**
	 * [name] getDisabled
	 * [type] method
	 * [scope] private
	 */
	private function getDisabled()
	{
		return $this->_disabled;
	}
	/**
	* [type] method
	* [name] addElement
	* [scope] public 
	* [expl] 
	*/
	public function addElement($value,$text,$selected=FALSE)
	{
		$this->_pointerOpt = sizeof($this->_arOpt);
		$this->_arOpt[$this->_pointerOpt]['value']	= $value;
		$this->_arOpt[$this->_pointerOpt]['text']	= $text;
		if($value == $this->_selected)
		{
			$selected = TRUE;
		}
		$this->_arOpt[$this->_pointerOpt]['selected'] = $selected;
		$this->_arOpt[$this->_pointerOpt]['disabled'] = $this->getDisabled();
	}
	
	/**
	* [type] method
	* [name] getSize
	* [scope] private 
	* [expl] 
	*/
	private function getSize() { return $this->_size; }
	/**
	* [type] method
	* [name] returnArOpt
	* [scope] private 
	* [expl] 
	*/
	private function returnArOpt() { return $this->_arOpt; }
	
	/**
	* [type] method
	* [name] changeOpt
	* [scope] 
	* [expl] changOpt	-> verandert een waarde binnen de array (om bvb nadien selected te bepalen
	* [expl]	parameter $k	: positie in de array
	* [expl]	rest werkt als setOpt
	*/
	function changeOpt($k,$value,$text,$selected=FALSE,$disabled=FALSE)
	{
		$this->_arOpt[$k]['value'] = $value;
		$this->_arOpt[$k]['text']	= $text;
		$this->_arOpt[$k]['selected'] = $selected;
		$this->_arOpt[$k]['disabled'] = $disabled;
	}
	
	/**
	* [type] method
	* [name] _prepare
	* [scope] private
	* [expl] 
	*/
	private function _prepare()
	{
		try
		{

			if(!HTML::$html_set || !HTML::$head_set || !HTML::$body_set )
			{
				throw new WebException("<b>Select class exception.</b><br />Either &lt;html&gt; or &lt;head&gt; or &lt;body&gt; is not set.</b><br />
					All these tags need to be set in this order to generate valid html forms.");
			}
            
			if ($this->getName() == '')
			{
				throw new WebException("<b>Select class exception.</b><br />Name is not set.");
			}
	
			if(sizeof($this->_arOpt) == "0")
			{
				throw new WebException("<b>Select class exception.</b><br />No values for selection set.");
			}

			$toHtml = '<select name="'
				.$this->getName().'" size="'.$this->getSize().'" ';

			if($this->getId() != '')
			{
				$toHtml .= ' id="'.$this->getId().'" ';
			}

			if ($this->getJs()  != '')
			{
				$toHtml .= ' '.$this->getJs().' ';
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
				elseif ($this->_arOpt[$i]['disabled'])
				{
					$this->_option .= '<option disabled="disabled" value="'
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
		catch(WebException $e)
		{
			echo $e->getMessage();
		}
	}
	
}

?>
