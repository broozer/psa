<?php

/**
* [name] Link.php
*/

class Link extends Base
{
	private $_href = '';
	private $_target = '';
	private $_title = '';
	
	public function __construct()
	{
		try
		{
			if(!Page::$html_set || !Page::$head_set || !Page::$body_set )
			{
				throw new PageException("<b>Link class exception</b><br />Either &lt;html&gt; or &lt;head&gt; or &lt;body&gt; is not set.</b><br />
					All these tags need to be set in this order to generate valid html forms.");
			}
		}
		catch(PageException $e)
		{
			echo $e->getMessage();
		}
	}
	
	public function setHref($data) { $this->_href = $data ;}
	public function setTarget($data) { $this->_target = $data ;}
	public function setTitle($data) { $this->_title = $data ; }
	private function getHref() { return $this->_href; }
	private function getTarget() { return $this->_target; }
	private function getTitle() { return $this->_title; }

	
	public function build()
	{
		$this->_prepare();		
		$this->display();
	}
	
	public function dump()
	{
		$this->_prepare();
		return $this->html;
	}
	
	private function _prepare()
	{
		try
		{
			if ($this->getHref() == '')
			{
				throw new PageException("<b>Link class exception</b><br />You need to set the anchor (href) for this element.</b><br />
					Usage : link->setHref(&lt;url for link&gt;);.");
			}
	
			if ($this->getName() == '')
			{
				throw new PageException("<b>Link class exception</b><br />You need to set the name element for this element.</b><br />
					Usage : link->setName(&lt;name for link&gt;);.");
			}
	
				$toHtml = '<a href="'.$this->getHref().'" ';
				$adder = '';
				
				
				if ($this->_target != "")
				{
					$adder .= ' target="'.$this->_target.'" ';
				}

				if ($this->_title != "")
				{
					$adder .= ' title="'.$this->_title.'" ';
				}
				
				if ($this->getId() != "")
				{
					$adder .= ' id="'.$this->getId().'" ';
				}
				
				if ($this->getJs() != "")
				{
					$adder.= ' '.$this->getJs().' ';
				}
				
				if ($this->getClas() != '')
				{
					$adder .= ' class="'.$this->getClas().'" ';
				}
				
				$total = $toHtml.$adder.'>'.$this->getName().'</a>';
				
				$this->html = $total;
		}
		catch(PageException $e)
		{
			echo $e->getMessage();
		}
	}
}

?>
