<?php

/*
** [file] Pict.php
** [author] Wim Paulussen
** [since] 2006-12-22
** [update] 2007-01-05 - removed __destruct , replaced by close
** [update] 2007-08-25 : this->tekst = $this->html // build dynamisch opbouwen
** [todo] all
** [todo] 
** [end]
*/

/*
** [class] Pict
** [extend] Body
** [extend] Html
*/


class Pict extends Web
{
	/* 
	** [var] source
	** [scope] private
	** [expl] source for picture
	** [end]
	*/
	private $_source;
	private $_width;
	private $_height;
	private $_alt = 'nn';
	/*
	** [function] setSource
	** [scope] public
	** [expl] set source for picture
	** [end]
	*/
	public function setSource($data) { $this->_source	= $data; }
	function setWidth($data) { $this->_width = $data; }
	function setHeight($data) { $this->_height = $data; }
	function setAlt($data) { $this->_alt	= $data; }
	
	function getSource() { return $this->_source; }
	function getWidth() { return $this->_width; }
	function getHeight() { return $this->_height; }
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
			if(!HTML::$html_set || !HTML::$head_set || !HTML::$body_set )
			{
				throw new WebException("<b>Pict class exception</b><br />Either &lt;html&gt; or &lt;head&gt; or &lt;body&gt; is not set.</b><br />
					All these tags need to be set in this order to generate valid html forms.");
			}
		}
		catch(WebException $e)
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
            if ($this->getHeight() != 0)
            {
                $this->html .= '" height="'.$this->getHeight();
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

?>
