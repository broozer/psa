<?php

/**
* [name] Link.php
* [type] file
* [package] Web
* [author] Wim Paulussen
* [since] 2007-01-10
* [update] 2007-01-23 : validation on target
* [update] 2007-03-25 : added setJs / getJs
* [update] 2007-05-22 : added get/setClas (inherited from Body)
* [update] 2008-02-05 : " before target removed
* [update] 2009-01-13 : " before target added - _self eruit - debug link build en dump vooor target
* [todo]
*/

/**
* [name] Link
* [type] class
* [extend] Web
*/
class Link extends Web
{
	/**
	* [name] _href
	* [type] attribute
	* [scope] private
	* [expl] url to link to
	*/
	private $_href = '';
	/** 
	* [name] _target
	* [type] attribute
	* [scope] private
	* [expl] blank , window name - standard = _self
	* [expl] NOT STANDARD XHTML
	*/
	private $_target = '';
	/**
	* [name] __construct
	* [type] method
	* [scope] public
	* [expl] checks for html-head-body
	*/
	public function __construct()
	{
		try
		{
			if(!HTML::$html_set || !HTML::$head_set || !HTML::$body_set )
			{
				throw new WebException("<b>Link class exception</b><br />Either &lt;html&gt; or &lt;head&gt; or &lt;body&gt; is not set.</b><br />
					All these tags need to be set in this order to generate valid html forms.");
			}
		}
		catch(WebException $e)
		{
			echo $e->getMessage();
		}
	}
	/**
	* [type] method
	* [name] setHref
	* [scope] public
	* [expl] sets href
	*/
	public function setHref($data) { $this->_href = $data ;}
	/**
	* [type] method
	* [name] setTarget
	* [scope] public
	* [expl] sets target (_blank, _self, <windowname>)
	*/
	public function setTarget($data) { $this->_target = $data ;}
	/**
	* [type] method
	* [name] getHref
	* [scope] public
	* [expl] sets href
	*/
	private function getHref() { return $this->_href; }
	/**
	* [type] method
	* [name]getTarget
	* [scope] private
	* [expl] returns the target
	*/
	private function getTarget() { return $this->_target; }
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
	* [name] prepare
	* [scope] public
	* [expl] prepares string for dump or build
	*/
	private function _prepare()
	{
		try
		{
			if ($this->getHref() == '')
			{
				throw new WebException("<b>Link class exception</b><br />You need to set the anchor (href) for this element.</b><br />
					Usage : link->setHref(&lt;url for link&gt;);.");
			}
	
			if ($this->getName() == '')
			{
				throw new WebException("<b>Link class exception</b><br />You need to set the name element for this element.</b><br />
					Usage : link->setName(&lt;name for link&gt;);.");
			}
	
				$toHtml = '<a href="'.$this->getHref().'" ';
				$adder = '';
				
				
				if ($this->_target != "")
				{
					$adder .= ' target="'.$this->_target.'" ';
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
		catch(WebException $e)
		{
			echo $e->getMessage();
		}
	}
}

?>
