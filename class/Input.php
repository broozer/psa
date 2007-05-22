<?php

/*
** [type] file
** [name] Input.php
** [author] Wim Paulussen
** [since] 2007-01-09
** [update] 2007-01-22 getJs iso getJava
** [update] 2007-02-03 setChecked debug/update
** [update] 2007-05-21 documentation // getClas toegevoegd
** [todo] All
** [end]
*/

/*
** [class] Input
** [extend] Body
** [extend] Html
** [extend] Session
** [end]
*/
class Input extends Body
{
	/* 
	** [type] attribute
	** [name] _value
	** [scope] private
	** [expl] value for input field
	** [end]
	*/
	private $_value = '';
	/* 
	** [type] attribute
	** [name] _type
	** [scope] private
	** [expl] input type - standard = 'text'
	** [end]
	*/
	private $_type	= 'text';
	/* 
	** [type] attribute
	** [name] _size
	** [scope] private
	** [expl] input size - standard = 5
	** [end]
	*/
	private $_size = 5;
	/* 
	** [type] attribute
	** [name] _maxlength
	** [scope] private
	** [expl] input maxlength property - if not set defaults to 'size' value
	** [end]
	*/
	private $_maxlength = 0;
	/* 
	** [type] attribute
	** [name] _readonly
	** [scope] private
	** [expl] input readonly - standard = false
	** [end]
	*/
	private $_readonly = false;
	/* 
	** [type] attribute
	** [name] _disabled
	** [scope] private
	** [expl] input disable - standard = false
	** [end]
	*/
	private $_disabled = false;
	/* 
	** [type] attribute
	** [name] _checked
	** [scope] private
	** [expl] input checked - standard = false
	** [end]
	*/
	private $_checked = false;
	/* 
	** [type] attribute
	** [name] _error
	** [scope] private
	** [expl] input error class - still on its own
	** [end]
	*/
	private $_error = '';
	/* 
	** [type] attribute
	** [name] _tabindex
	** [scope] private
	** [expl] input tabindex - standard none
	** [end]
	*/
	private $_tabindex = '';
	
	// sets
	/*
	** [type] method
	** [name] setValue
	** [scope] public
	** [expl] set Value
	** [end]
	*/
	public function setValue($data) { $this->_value	= $data; }
	/*
	** [type] method
	** [name] setType
	** [scope] public
	** [expl] set Type
	** [expl] <ul><li>text</li>
	** [expl] <li>hidden</li>
	** [expl] <li>checkbox</li>
	** [expl] <li>submit :  needs value</li>
	** [expl] <li>password</li>
	** [expl] <li>reset : needs value</li>
	** [expl] <li>radio</li>
	** [expl] <li>file</li>
	** [expl] <li>button</li></ul>
	** [end]
	*/
	public function setType($data) { $this->_type = $data; }
	public function setSize($data) { $this->_size	= $data; }
	public function setMaxlength($data) { $this->_maxlength	= $data; }
	public function setReadonly($data) { $this->_readonly	= $data; }
	public function setDisabled($data) { $this->_disabled	= $data; }
	public function setChecked($data) { $this->_checked	= $data; }
	private function setError($data) { $this->_error .= $data; }
	public function setTabindex($data) {$this->_tabindex = $data; }
	
	// gets
	private function getValue() {return $this->_value; }
	private function getType() {return $this->_type; }
	private function getSize() {return $this->_size; }
	private function getMaxlength() {return $this->_maxlength; }
	private function getReadonly() {return $this->_readonly; }
	private function getDisabled() {return $this->_disabled; }
	private function getChecked() {return $this->_checked; }
	private function getError() { return $this->_error; }
	private function getTabindex() { return $this->_tabindex; }
	
	/*
	** [type] method
	** [name] build
	** [scope] public
	** [expl] after all tags are set , you run this function
	** [end]
	*/
	public function build()
	{
		// waarde element TYPE onderzoeken , indien niet gezet -> text
		if (!$this->_validtype($this->getType()))
		{
			$this->setError("No valid Input type.<br>");
		}

		if ($this->getName() == '')
		{
			$this->setError("No value set for field name (compulsory)<br>");
		}

		if($this->getType() == "submit" && $this->getValue() == '')
		{
			$this->setError("Submit has no 'value'<br>");
		}

		if($this->getType() == "reset" && $this->getValue() == '')
		{
			$this->setError("Reset has no 'value'<br>");
		}
		
		if ($this->getMaxlength() == '0')
		{
			$this->setMaxlength($this->getSize());
		}

		if ($this->getError() == '')
		{
			if($this->_type == 'file')
			{
				$this->html = '<input type="file" name="'.$this->getName().'" />';
				return $this->html;
			}
			else
			{
				
				$this->html = '<input type="'
					.$this->getType().'"';
					
					if ($this->getReadonly())
					{
						$this->html .= ' readonly ';
					}
					
					if ($this->getChecked())
					{
						$this->html .= ' checked';
					}
					
					if ($this->getDisabled())
					{
						$this->html .= ' disabled';
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
						$this->html .= ' '.$this->getJs().'"';
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
		else
		{
			die ($this->getError());
		}
	}

	/*
	** [type] method
	** [name] _validtype
	** [scope] private
	** [expl] checks validity of input type
	** [end]
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
