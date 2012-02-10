<?php

/**
* [type] file
* [name] Textarea.php
* [package] Web
* [author] Wim Paulussen
* [since] 2006-12-22
*/

class Textarea extends Base
{
	private $values = '';
	private $rows	= '3';
	private $cols = '60';
	private $readonly = FALSE;
	private $_label = '';
	
	function setValue($data) { $this->values = $data; }
	function setRows($data) { $this->rows = $data; }
	function setCols($data) { $this->cols = $data; }
	function setReadonly() { $this->readonly = TRUE; }
	public function setLabel($data) { $this->_label = $data; }
	private function getLabel() {return $this->_label; }
	
	public function build() {
		$this->_prepare();
		if($this->getLabel() != '') {
            if($this->getid() == '') {
                throw new PageException("<b>Select class exception.</b><br />Input id needs to be set before label can be created");
            }
		    $string = '<label for="'.$this->getId().'">'.$this->getLabel().'</label>';
		    $this->html = $string.$this->html;
	    }
		$this->display();
	}
	
	public function dump() {
		$this->_prepare();
		if($this->getLabel() != '') {
            if($this->getid() == '') {
                throw new PageException("<b>Select class exception.</b><br />Input id needs to be set before label can be created");
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
	function _prepare() {
		try
		{
			if(!Page::$html_set || !Page::$head_set || !Page::$body_set ) {
				throw new PageException("<b>Textarea class exception.</b><br />Either &lt;html&gt; or &lt;head&gt; or &lt;body&gt; is not set.</b><br />
					All these tags need to be set in this order to generate valid html forms.");
			}
		
			if ($this->getName() == '') {
				throw new WebException("<b>Textarea class exception.</b><br />Name is not set.");
			}
	
			$this->html	 = '<textarea name="';
			$this->html	.= $this->getName();
			$this->html	.= '" rows="';
			$this->html	.=$this->rows;
			$this->html	.='" cols="';
			$this->html	.=$this->cols;
			$this->html	.= '"';
	
			if ($this->readonly) {
				$this->html .= " readonly ";
			}
	
			if ($this->id != '') {
				$this->html .= ' id="'.$this->getId().'"';
			}
	
			$this->html	.= '>'.$this->values.'</textarea>';
	
			return $this->html;
		} catch(PageException $e) {
			echo $e->getMessage();
		}
	}
}

?>