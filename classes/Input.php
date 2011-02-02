<?php

/**
* [name] Input.php
* [type] file
* [package] Web
* [author] Wim Paulussen
* [since] 2007-01-09
* [update] 2007-01-22 getJs iso getJava
* [update] 2007-02-03 setChecked debug/update
* [update] 2007-08-26 with file set ID
* [update] 2008-06-14 checked="checked"
* [update] 2009-01-22 : exception
* [update] 2009-02-09 : changed (corrected) label tags
* [update] 2009-02-12 : Input may be invoked before html , but error when build/dump
* [todo] 
*/

/**
* [name] Input
* [type] class
* [extend] Web
*/
class Input extends Web
{
	/** 
	* [name] _value
	* [type] var
	* [scope] private
	* [expl] value for input field
	*/
	private $_value = '';
	/** 
	* [name] _type
	* [type] var
	* [scope] private
	* [expl] input type - standard = 'text'
	*/
	private $_type	= 'text';
	/** 
	* [name] _size
	* [type] var
	* [scope] private
	* [expl] input size - standard = 5
	*/
	private $_size = 5;
	/** 
	* [name] _maxlength
	* [type] var
	* [scope] private
	* [expl] input maxlength property - if not set defaults to 'size' value
	*/
	private $_maxlength = 0;
	/** 
	* [name] _readonly
	* [type] var
	* [scope] private
	* [expl] input readonly - standard = false
	*/
	private $_readonly = false;
	/** 
	* [name] _disabled
	* [type] var
	* [scope] private
	* [expl] input disable - standard = false
	*/
	private $_disabled = false;
	/** 
	* [name] _checked
	* [type] var
	* [scope] private
	* [expl] input checked - standard = false
	*/
	private $_checked = false;
	/** 
	* [name] _error
	* [type] var
	* [scope] private
	* [expl] input error class - still on its own
	*/
	private $_error = '';
	/** 
	* [name] _tabindex
	* [type] var
	* [scope] private
	* [expl] input tabindex - standard none
	*/
	private $_tabindex = '';
	/** 
	* [name] _label
	* [type] var
	* [scope] private
	* [expl] input label 
	*/
	
	private $_label = '';
	
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
	
	
	// sets
	/**
	* [name] setValue
	* [type] var
	* [scope] public
	* [expl] set Value
	*/
	public function setValue($data) { $this->_value	= $data; }
	/**
	* [name] setType
	* [type] method
	* [type] var
	* [scope] public
	* [expl] set Type
	* [expl] - text
	* [expl] - hidden
	* [expl] - checkbox
	* [expl] - submit :  needs value
	* [expl] - password
	* [expl] - reset : needs value
	* [expl] - radio
	* [expl] - file (check enctype in form)
	* [expl] - button
	*/
	public function setType($data) { $this->_type = $data; }
	public function setLabel($data) { $this->_label = $data; }
	public function setSize($data) { $this->_size	= $data; }
	public function setMaxlength($data) { $this->_maxlength	= $data; }
	public function setReadonly($data) { $this->_readonly	= $data; }
	public function setDisabled($data) { $this->_disabled	= $data; }
	public function setChecked($data) { $this->_checked	= $data; }
	private function setError($data) { $this->_error .= $data; }
	public function setTabindex($data) {$this->_tabindex = $data; }
	
	// gets
	/**
	 * [comment] 2007-12-22 : made public for checking
	 */
	public function getValue() {return $this->_value; }
	private function getType() {return $this->_type; }
	private function getLabel() {return $this->_label; }
	private function getSize() {return $this->_size; }
	private function getMaxlength() {return $this->_maxlength; }
	private function getReadonly() {return $this->_readonly; }
	private function getDisabled() {return $this->_disabled; }
	private function getChecked() {return $this->_checked; }
	private function getError() { return $this->_error; }
	private function getTabindex() { return $this->_tabindex; }
	
	/**
	* [name] build
	* [type] method
	* [scope] public
	* [expl] display built string
	*/
	public function build()
	{
		$this->_prepare();
		if($this->getLabel() != '')
		{
			$string = '<label>'.$this->getLabel().'</label>';
			$this->html = $string.$this->html;
		}
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
	* [name] _prepare
	* [type] method
	* [scope] private
	* [expl] prepares the $this->html string
	*/
	private function _prepare()
	{
		try
		{
			/**
			* [comment] waarde element TYPE onderzoeken , indien niet gezet -> text
			*/
			if(!HTML::$html_set || !HTML::$head_set || !HTML::$body_set )
			{
				throw new WebException("<b>Input class exception.</b><br />Either &lt;html&gt; or &lt;head&gt; or &lt;body&gt; is not set.</b><br />
					All these tags need to be set in this order to generate valid html forms.");
			}
			
			if (!$this->_validtype($this->getType()))
			{
				throw new WebException("<b>Input class exception.</b><br />No valid types set. Valid types are :<ul>
				 <li>text</li>
				 <li>hidden</li>
				 <li>checkbox</li>
				 <li>submit :  needs value</li>
				 <li>password</li>
				 <li>reset : needs value</li>
				 <li>radio</li>
				 <li>file (check enctype in form)</li>
				 <li>button</li></ul>");
			}
	
			if ($this->getName() == '')
			{
				throw new WebException("<b>Input class exception.</b><br />Input always needs a 'name' set.");
			}
	
			if($this->getType() == "submit" && $this->getValue() == '')
			{
				throw new WebException("<b>Input class exception.</b><br />If 'submit' as type then you need to set a value.");
			}
	
			if($this->getType() == "reset" && $this->getValue() == '')
			{
				throw new WebException("<b>Input class exception.</b><br />If 'reset' as type then you need to set a value.");
			}
			
			if($this->getType() == "file" && !Form::$enctype_set)
			{
				throw new WebException("<b>Input class exception.</b><br />If 'file' as type then you need to set enctype to 'multipart/form-data'.");
			}
			
			if ($this->getMaxlength() == '0')
			{
				$this->setMaxlength($this->getSize());
			}
	
			if ($this->getError() == '')
			{
				if($this->_type == 'file')
				{
					$this->html = '<input type="file" name="'.$this->getName().'"';
					if ($this->getId() != '')
					{
						$this->html .= ' id="'.$this->getId().'"';
					}
					$this->html .= ' />';
					return $this->html;
				}
				else
				{
					
					$this->html = '<input type="'
						.$this->getType().'"';
						
						if ($this->getReadonly())
						{
							$this->html .= ' readonly="readonly" ';
						}
						
						if ($this->getChecked())
						{
							$this->html .= ' checked="checked" ';
						}
						
						if ($this->getDisabled())
						{
							$this->html .= ' disabled="disabled" ';
						}
						
						if ($this->getId() != '')
						{
							$this->html .= ' id="'.$this->getId().'"';
						}
						
						if ($this->getClas() != '')
						{
							$this->html .= ' class="'.$this->getClas().'"';
						}
						
						if ($this->getTabindex() != '')
						{
							$this->html .= ' tabindex="'.$this->getTabindex().'" ';
						}
						
						if ($this->getJs()  != '')
						{
							// 2009-10-19 - trailing " weggedaan
							$this->html .= ' '.$this->getJs().' ';
						}
						
						$this->html 
						.=' name="'
						.$this->getName()
						.'" value="'
						.$this->getValue()
						.'" size="'
						.$this->getSize()
						.'" maxlength="'
						.$this->getMaxlength()
						.'" />';
					return $this->html;
				}
			}
		}
		catch(WebException $e)
		{
			echo $e->getMessage();
		}
	}

	/**
	* [name] _validtype
	* [type] method
	* [scope] private
	* [expl] checks validity of input type
	* [expl] valid types :
	* [expl] - text
	* [expl] - hidden
	* [expl] - checkbox
	* [expl] - submit :  needs value
	* [expl] - password
	* [expl] - reset : needs value
	* [expl] - radio
	* [expl] - file (check enctype in form)
	* [expl] - button
	*/
	private function _validtype($test)
	{
		if ($test == "hidden" || $test == "submit" || $test == "password"
			|| $test == "checkbox" || $test == "reset"  || $test == "radio" 
			|| $test == "text" || $test == "button" || $test == 'file')
		{
			return true;
		}
		else
		{
			return false;
		}
	}
}	
?>
