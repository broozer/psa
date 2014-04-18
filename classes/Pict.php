<?php

/**
 * [file] Pict.php
 * [author] Wim Paulussen
 * [since] 2006-12-22
 * [update] 2011.11.03 to pages
 */

/**
 * [class] Pict
 * [extend] Body
 * [extend] Html
 */


class Pict extends Base
{
	/**
	 * [var] source
	 * [scope] private
	 * [expl] source for picture
     */
	private $_source;
	private $_width;
	private $_heigth;
	private $_alt = 'nn';
	/**
	 * [function] setSource
	 * [scope] public
	 * [expl] set source for picture
	 */
	public function setSource($data) { $this->_source	= $data; }
	function setWidth($data) { $this->_width = $data; }
	function setHeigth($data) { $this->_heigth = $data; }
	function setAlt($data) { $this->_alt	= $data; }
	
	function getSource() { return $this->_source; }
	function getWidth() { return $this->_width; }
	function getHeigth() { return $this->_heigth; }
	function getAlt() { return $this->_alt; }

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
			if(!Page::$html_set || !Page::$head_set || !Page::$body_set )
			{
				throw new WebException("<b>Pict class exception</b><br />Either &lt;html&gt; or &lt;head&gt; or &lt;body&gt; is not set.</b><br />
					All these tags need to be set in this order to generate valid html forms.");
			}
		}
		catch(PageException $e)
		{
			echo $e->getMessage();
		}
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
	 * [name] prepare
	 * [scope] public
	 * [expl] prepares string for dump or build
	 */
	private function _prepare()
	{
		try
		{
            $this->html	= '<img src="'.$this->getSource();
            if ($this->getWidth() != 0)
            {
                $this->html .= '" width="'.$this->getWidth();
            }
            if ($this->getHeigth() != 0)
            {
                $this->html .= '" heigth="'.$this->getHeigth();
            }
            if ($this->getId() != '')
            {
                $this->html .= '" id="'.$this->getId();
            }
            $this->html .= '" alt="'.$this->getAlt().'" />';
		}
		catch(WebException $e)
		{
			echo $e->getMessage();
		}
	}

}