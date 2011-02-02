<?php

/**
* [type] file
* [name] Form.php
* [package] Web
* [author] Wim Paulussen
* [since] 2007-01-11
* [update] 2007-01-18 : debug error
* [update] 2007-01-23 : reset setName en Settarget voor validatie
* [update] 2007-04-01 : target debugged voor jade
* [update] 2009-01-22 : exception handling
* [update] 2009-02-09 : if build and setAction = '' -> throw error
* [todo] testing setEnctype / setTarget
*/

/**
* [name] Form
* [type] class
* [extend] Web
*/
class Form extends Web
{
	/** 
	* [type] attribute
	* [name] _action
	* [scope] private
	* [expl] file (url) that needs to be executed
	*/
	private $_action	= '';
	/**
	* [type] attribute
	* [name] _method
	* [scope] private
	* [expl] either POST or GET (standard = POST)
	*/
	private $_method	= 'post';
	/** 
	* [type] attribute
	* [name] _target
	* [scope] private
	* [expl] standard = _self
	*/
	private $_target	= '_self';
	/** 
	* [type] attribute
	* [name] _enctype
	* [scope] private
	* [expl] standard NULL
	*/
	private $_enctype	= NULL;
	/** 
	* [type] attribute
	* [name] enctype_set
	* [scope] public static
	* [expl] will be set with form setEnctype
	*/
	public static $enctype_set = FALSE;
	
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
				throw new WebException("<b>Form class exception</b><br />Either &lt;html&gt; or &lt;head&gt; or &lt;body&gt; is not set.</b><br />
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
	* [name] setAction
	* [scope] public
	* [expl] sets file to execute
	*/
	public function setAction($data) 	
	{ 
		try
		{
			if (!file_exists($data))
			{
				throw new WebException("<b>Form class exception</b><br />File for redirect not set : '".$data."'");
				return FALSE;
			}
		}
		catch(WebException $e)
		{
			echo $e->getMessage();
		}
		$this->_action	= $data; 
	}
	
	/**
	* [type] method
	* [name] setEnctype
	* [scope] public
	* [expl] sets _enctype : application/x-www-form-urlencoded - multipart/form-data when INPUT type file is used
	*/
	public function setEnctype($data) 
	{ 
		try
		{
			if ($data != 'application/x-www-form-urlencoded' && $data != 'multipart/form-data')
			{
				throw new WebException("<b>Form class exception</b><br />Enctype is either 'application/x-www-form-urlencoded' or 
					'multipart/form-data'<br />");
			}
		}
		catch(WebException $e)
		{
			echo $e->getMessage();
		}
		self::$enctype_set = TRUE;
		$this->_enctype = $data; 
	}
	/**
	* [type] method
	* [name] setTarget
	* [scope] public
	* [expl] sets _target
	*/
	public function setTarget($data) 
	{ 
		$this->_target = $data;
	}
	/**
	* [type] method
	* [name] setMethod
	* [scope] public
	* [expl] sets _method
	*/
	public function setMethod($data)	
	{ 
		try
		{
			if ($data != 'post' && $data != 'get')
			{
				throw new WebException("<b>Form class exception</b><br />Method data is 'post' or 'get' (standard : post)");
				return FALSE;
			}
		}
		catch(WebException $e)
		{
			echo $e->getMessage();
		}
		$this->_method = $data;
		return TRUE;
	}
	
	/**
	* [type] method
	* [name] build
	* [scope] public
	* [expl] after all tags are set , you run this function
	*/
	function build()
	{
		try
		{
			if($this->_action == '')
			{
				throw new WebException("<b>Form class exception</b><br />No action file set (use setAction('&lt;filename&gt;')");
				return FALSE;
			}
			$this->html = '<form action="'
				.$this->_action
				.'" method="'
				.$this->_method.'"';
	
			if(!$this->getName() == '')
			{
				$this->html .= ' name="'
					. $this->getName().'"';
			}
	
			if($this->_target != '_self')
			{
				$this->html .= ' target="'
					. $this->_target.'"';
			}
	
			if (!$this->_enctype == NULL)
			{
				$this->html .= ' enctype="'
					. $this->_enctype.'"';
			}
			
			if (!$this->getId() == '')
			{
				$this->html .= ' id="'
					. $this->getId().'"';
			}
			
			if (!$this->getJs() == '')
			{
				$this->html .=' '.$this->getJs().' ';
			}
			
			$this->html .= '>'
				."\n";
				
			// debug for trailing " echo 'form direct output : <pre>'.$this->html.'</pre>';
			$this->display();
		}
		catch(WebException $e)
		{
			echo $e->getMessage();
		}
	}
	/**
	* [type] method
	* [name] __destruct
	* [scope] public
	* [expl] gives 'final' tag
	*/
	public function __destruct()
	{
		$this->html = "</form>\n";
		$this->display();
	}
}
?>