<?php

/**
* [name] Input.php
*/

class Input extends Base
{
	
	private $_value = '';
	private $_type	= 'text';
	private $_size = 5;
	private $_maxlength = 0;
	private $_readonly = false;
	private $_disabled = false;
	private $_checked = false;
	private $_error = '';
	private $_tabindex = '';	
	private $_label = '';
    private $_placeholder = '';
    private $_autofocus = FALSE;
    private $_required = FALSE;
	
	public function __construct()
	{
		//void
	}

	public function setNameId($data) {
		$this->name = $data;
		$this->setId($data);
	}
	
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
    * - email
	*/
	public function setType($data) { $this->_type = $data; }
	public function setLabel($data) { $this->_label = $data; }
	public function setSize($data) { $this->_size	= $data; }
	public function setMaxlength($data) { $this->_maxlength	= $data; }
	public function setReadonly() { $this->_readonly	= TRUE; }
	public function setDisabled() { $this->_disabled	= TRUE; }
	public function setChecked() { $this->_checked	= TRUE; }
	private function setError($data) { $this->_error .= $data; }
	public function setTabindex($data) {$this->_tabindex = $data; }
    // html5
    public function setPlaceholder($data) { $this->_placeholder = $data; }
    public function setAutofocus() { $this->_autofocus = TRUE; }
    public function setRequired() { $this->_required = TRUE; }
	
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
    // html5
    private function getPlaceholder() {return $this->_placeholder; }
	private function getAutofocus() {return $this->_autofocus; }
    private function getRequired() {return $this->_required; }
	/**
	* [name] build
	* [type] method
	* [scope] public
	* [expl] display built string
	*/
	public function build()
	{
        try {
		    $this->_prepare();
		    if($this->getLabel() != '')
		    {
                if($this->getid() == '') {
                    throw new PageException("<b>Input class exception.</b><br />Input id needs to be set before label can be created");
                }
			    $string = '<label for="'.$this->getId().'">'.$this->getLabel().'</label>';
			    $this->html = $string.$this->html;
		    }
		    $this->display();
        } catch(PageException $e) {
			echo $e->getMessage();
		}
	}
	
	public function dump()
	{
		$this->_prepare();
		if($this->getLabel() != '')
		    {
                if($this->getid() == '') {
                    throw new PageException("<b>Input class exception.</b><br />Input id needs to be set before label can be created");
                }
			    $string = '<label for="'.$this->getId().'">'.$this->getLabel().'</label>';
			    $this->html = $string.$this->html;
		    }
		return $this->html;
	}
	
	private function _prepare()
	{
		try
		{
			/**
			* [comment] waarde element TYPE onderzoeken , indien niet gezet -> text
			*/
			if(!Page::$html_set || !Page::$head_set || !Page::$body_set )
			{
				throw new PageException("<b>Input class exception.</b><br />Either &lt;html&gt; or &lt;head&gt; or &lt;body&gt; is not set.</b><br />
					All these tags need to be set in this order to generate valid html forms.");
			}
			
			if (!$this->_validtype($this->getType()))
			{
				throw new PageException("<b>Input class exception.</b><br />No valid types set. Valid types are :<ul>
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
				throw new PageException("<b>Input class exception.</b><br />Input always needs a 'name' set.");
			}
	
			if($this->getType() == "submit" && $this->getValue() == '')
			{
				throw new PageException("<b>Input class exception.</b><br />If 'submit' as type then you need to set a value.");
			}
	
			if($this->getType() == "reset" && $this->getValue() == '')
			{
				throw new PageException("<b>Input class exception.</b><br />If 'reset' as type then you need to set a value.");
			}
			
			if($this->getType() == "file" && !Form::$enctype_set)
			{
				throw new PageException("<b>Input class exception.</b><br />If 'file' as type then you need to set enctype to 'multipart/form-data'.");
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
					$this->html .= ' >';
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

                        if ($this->getRequired())
						{
							$this->html .= ' required="required" ';
						}

                        if ($this->getAutofocus()) {
	                        $this->html .= ' autofocus ';			
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
						

                        if ($this->getPlaceholder() != '')
						{
							$this->html .= ' placeholder="'.$this->getPlaceholder().'" ';
						}

						if ($this->getJs()  != '')
						{
							$this->html .= ' '.$this->getJs().' ';
						}

						if($this->getType() == "submit" 
							|| $this->getType() == "hidden"
							|| $this->getType() == "button") {
							// html5 : submit no size no maxlenght
							$this->html 
							.=' name="'
							.$this->getName()
							.'" value="'
							.$this->getValue()
							.'" />';
						} else {
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
						}
					return $this->html;
				}
			}
		}
		catch(PageException $e)
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
    * - email
	*/
	private function _validtype($test)
	{
		if ($test == "hidden" || $test == "submit" || $test == "password"
			|| $test == "checkbox" || $test == "reset"  || $test == "radio" 
			|| $test == "text" || $test == "button" || $test == 'file' || $test == 'email'
            || $test == "date" )
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
