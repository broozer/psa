<?php

/**
* [type] file
*/

class Form extends Base
{
	private $_action	= '';
	private $_method	= 'post';
	private $_target	= '_self';
	private $_enctype;
	public static $enctype_set = FALSE;
	
	public function __construct()
	{
		try
		{
			if(!Page::$html_set || !Page::$head_set || !Page::$body_set )
			{
				throw new PageException("<b>Form class exception</b><br />Either &lt;html&gt; or &lt;head&gt; or &lt;body&gt; is not set.</b><br />
					All these tags need to be set in this order to generate valid html forms.");
			}
		}
		catch(PageException $e)
		{
			echo $e->getMessage();
		}
	}
	
	public function setAction($data) 	
	{ 
		try
		{
			if (!file_exists($data))
			{
				throw new PageException("<b>Form class exception</b><br />File for redirect not set : '".$data."'");
				return FALSE;
			}
		}
		catch(PageException $e)
		{
			echo $e->getMessage();
		}
		$this->_action	= $data; 
	}
	
	public function setEnctype($data) 
	{ 
		try
		{
			if ($data != 'application/x-www-form-urlencoded' && $data != 'multipart/form-data')
			{
				throw new PageException("<b>Form class exception</b><br />Enctype is either 'application/x-www-form-urlencoded' or 
					'multipart/form-data'<br />");
			}
		}
		catch(PageException $e)
		{
			echo $e->getMessage();
		}
		self::$enctype_set = TRUE;
		$this->_enctype = $data; 
	}
	
	public function setTarget($data) 
	{ 
		$this->_target = $data;
	}
	
	public function setMethod($data)	
	{ 
		try
		{
			if ($data != 'post' && $data != 'get')
			{
				throw new PageException("<b>Form class exception</b><br />Method data is 'post' or 'get' (standard : post)");
				return FALSE;
			}
		}
		catch(PageException $e)
		{
			echo $e->getMessage();
		}
		$this->_method = $data;
		return TRUE;
	}
	

	function build()
	{
		try
		{
			if($this->_action == '')
			{
				throw new PageException("<b>Form class exception</b><br />No action file set (use setAction('&lt;filename&gt;')");
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
	
			if (isset($this->_enctype))
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
				
			$this->display();
		}
		catch(PageException $e)
		{
			echo $e->getMessage();
		}
	}
	
	public function __destruct()
	{
		$this->html = "</form>\n";
		$this->display();
	}
}
?>
