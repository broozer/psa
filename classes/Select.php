<?php

/**
* [type] file
* [name] Select.php
*/

class Select extends Base
{
	private $_size = 1;
	private $_selected = FALSE;
	private $_disabled = FALSE;
	private $_arOpt = array();
	private $_pointerOpt;
	private $_option = '';
	private $_label = '';
	
	public function build()
	{
		try {
		
			$this->_prepare();
			if($this->getLabel() != '')
		    {
	            if($this->getid() == '') {
	                throw new PageException("<b>Select class exception.</b><br />Input id needs to be set before label can be created");
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
                throw new PageException("<b>Select class exception.</b><br />Select id needs to be set before label can be created");
            }
		    $string = '<label for="'.$this->getId().'">'.$this->getLabel().'</label>';
		    $this->html = $string.$this->html;
	    }
		
		return $this->html;
	}

	public function setNameId($data) {
		$this->name = $data;
		$this->setId($data);
	}
	
	public function setSize($data) {$this->_size = $data; }
	public function setSelected($data) {$this->_selected = $data; }
	public function setLabel($data) { $this->_label = $data; }
	private function getLabel() {return $this->_label; }
	function setDisabled($data) {$this->_disabled = $data; }
	private function getDisabled() { return $this->_disabled; }
	
	public function add($value,$text,$selected=FALSE) {
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
	
	private function getSize() { return $this->_size; }
	private function returnArOpt() { return $this->_arOpt; }
	function changeOpt($k,$value,$text,$selected=FALSE,$disabled=FALSE) {
		$this->_arOpt[$k]['value'] = $value;
		$this->_arOpt[$k]['text']	= $text;
		$this->_arOpt[$k]['selected'] = $selected;
		$this->_arOpt[$k]['disabled'] = $disabled;
	}
	
	private function _prepare() {
		try {
			
			if(!Page::$html_set || !Page::$head_set || !Page::$body_set ) {
				throw new PageException("<b>Select class exception.</b><br />Either &lt;html&gt; or &lt;head&gt; or &lt;body&gt; is not set.</b><br />
					All these tags need to be set in this order to generate valid html forms.");
			}
            
			if ($this->getName() == '') {
				throw new PageException("<b>Select class exception.</b><br />Name is not set.");
			}
	
			if(sizeof($this->_arOpt) == "0") {
				throw new PageException("<b>Select class exception.</b><br />No values for selection set.");
			}

			$toHtml = '<select name="'
				.$this->getName().'" size="'.$this->getSize().'" ';

			if($this->getId() != '') {
				$toHtml .= ' id="'.$this->getId().'" ';
			}

			if($this->getClas() != '') {
				$toHtml .= ' class="'.$this->getClas().'" ';
			}
			
			if ($this->getJs()  != '') {
				$toHtml .= ' '.$this->getJs().' ';
			}

			$toHtml .='>'."\n";
			
			for($i=0;$i<sizeof($this->_arOpt);++$i)	{
				$this->waarde	= $this->_arOpt[$i]['value'];
				$this->tektest	= $this->_arOpt[$i]['text'];

				if ($this->_arOpt[$i]['selected']) {
					$this->_option .= '<option selected="selected" value="'
						.$this->waarde
						.'">'
						.$this->tektest
						.'</option>'."\n";
				} elseif ($this->_arOpt[$i]['disabled']) {
					$this->_option .= '<option disabled="disabled" value="'
						.$this->waarde
						.'">'
						.$this->tektest
						.'</option>'."\n";
				} else 	{
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
		} catch(PageException $e) {
			echo $e->getMessage();
		}
	}
	
}