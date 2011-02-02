<?php

/**
* [name] Html.php
* [type] file
* [package] Web
* [author] Wim Paulussen
* [since] 2006-12-02
* [update] 2007-01-05 - removed __destruct , replaced by close
* [update] 2007-05-11 : debugged errorreporting
* [update] 2007-05-21 : documentation
* [update] 2007-09-27 : Exception handling added
* [update] 2009-01-16 : everything Exception and working
* [update] 2009-08-18 :	final statement including line breaks
*						doctype needs to be set before anything else
* [todo] output to screen or file
*/

/**
* [name] Html
* [type] class
* [extend] Web
*/

class Html extends Web
{
	
	/** 
	* [type] attribute
	* [name] doctype
	* [scope] private
	* [expl] on construction the following type can be set :
	* [expl] <ul><li>html4-strict</li>
	* [expl] <li>html4-loose</li>
	* [expl] <li>html4-frameset</li>
	* [expl] <li>xhtml-strict</li>
	* [expl] <li>xhtml-frameset</li>
	* [expl] <li>xhtml-loose</li></ul>
	*/
	private $doctype = '';
	/** 
	* [type] attribute
	* [name] language
	* [scope] private
	* [expl] defines language attribute in html-tag
	*/
	private $language;
	/** 
	* [type] attribute
	* [name] html_set
	* [scope] public static
	* [expl] will be set to true if html class is initiated
	*/
	public static $html_set = FALSE;
	/** 
	* [type] attribute
	* [name] head_set
	* [scope] private
	* [expl] will be set to true if head class is initiated
	*/
	public static $head_set = FALSE;
	/** 
	* [type] attribute
	* [name] body_set
	* [scope] private
	* [expl] will be set to true if body class is initiated
	*/
	public static $body_set = 0;
	
	/** 
	* [type] method
	* [name] __construct
	* [scope] global
	* [expl] set html_set to TRUE
	*/
	public function __construct() 
	{ 
		self::$html_set = TRUE;
	}
	/**
	* [type] method
	* [name] getHtml_set
	* [scope] global
	* [expl] returns value of html_set
	*/
	public static function getHtml_set()
	{
		if(self::$html_set)
		{
			return true;
		}
		return false;
	}
	/**
	* [type] method
	* [name] getHead_set
	* [scope] global
	* [expl] returns value of head_set
	*/
	public static function getHead_set()
	{
		if(self::$head_set)
		{
			return true;
		}
		return false;
	}
	/**
	* [type] method
	* [name] getBody_set
	* [scope] global
	* [expl] returns value of body_set
	*/
	public static function getBody_set()
	{
		if(self::$body_set)
		{
			return true;
		}
		return false;
	}
	/**
	* [type] method
	* [name] __destruct
	* [scope] global
	* [expl] flushes the buffered output
	*/
	public function __destruct()
	{
		try
		{
			if(!self::$html_set || !self::$head_set || !self::$body_set )
			{
				throw new WebException("<b>HTML class exception.</b><br />Either &lt;html&gt; or &lt;head&gt; or &lt;body&gt; is not set.</b><br />
					All these tags need to be used in order to generate valid html forms.");
			}
			if ($this->html != '')
			{
				$this->html .= "</body>\n</html>";
			}
			else
			{
				$this->html = "</body>\n</html>";
			} 
	
			$this->display();
		}
		catch(WebException $e)
		{
			echo $e->getMessage();
		}
	}

	/**
	* [type] method
	* [name] setDoctype
	* [scope] public
	* [expl] sets the doctype declaration based on a parameter
	* [expl] <ul><li>html4-strict</li>
	* [expl] <li>html4-loose (defaults)</li>
	* [expl] <li>html4-frameset</li>
	* [expl] <li>xhtml-strict</li>
	* [expl] <li>xhtml-frameset</li>
	* [expl] <li>xhtml-loose</li></ul>
	*/
	public function setDoctype($type)
	{
		$this->doctype = $type;
		switch($this->doctype)
		{
			case "html4-strict":
			$this->html = "<!DOCTYPE HTML PUBLIC \"-//W3C//DTD HTML 4.01//EN\"
\"http://www.w3.org/TR/html4/strict.dtd\">\n";
			break;

			case "html4-loose":
			$this->html = '<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">'."\n";
			break;

			case "html4-frameset":
			$this->html = '<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Frameset//EN"
"http://www.w3.org/TR/html4/frameset.dtd">'."\n";
			break;

			case "xhtml-strict":
			$this->html = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">'."\n";
			break;

			case "xhtml-frameset":
			$this->html = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">'."\n";
			break;

			case "xhtml-loose":
			$this->html = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">'."\n";
			break;

			default:
			$this->html = '<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">'."\n";
			break;
		}
	}

	/**
	* [type] method
	* [name] setLanguage
	* [scope] public
	* [expl] sets the language for the html tag
	* [expl] e.g. setLanguage('nl')
	* [expl] 
	*/
	public function setLanguage($lang)
	{
		try
		{
			if($this->doctype == '')
			{
				throw new WebException("<b>HTML class exception.</b><br />Doctype needs to be set");
			}
			$this->language = $lang;
			$this->html .= '<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="'.$this->language.'" lang="'.$this->language.'">'."\n";
		}
		catch(WebException $e)
		{
			echo $e->getMessage();
		}
	}

	/**
	* [type] method
	* [name] build
	* [scope] public
	* [expl] returns the html output to the display function
	* [expl] overloads web->build
	*/
	public function build()
	{
		try
		{
			if(!isset($this->doctype))
			{
				// echo 'Doctype not set';
			throw new WebException("<b>HTML class error.</b><br />Doctype not set.</b><br> 
				Usage \$objectname->setDoctype(\"&lt;doctype&gt;\")<br />
				<ul>doctypes
				<li>html4-strict</li>
				<li>html4-loose</li>
				<li>html4-frameset</li>
				<li>xhtml-strict</li>
				<li>xhtml-frameset</li>
				<li>xhtml-loose</li></ul> ");
			}
			
			if(!isset($this->language))
			{
				throw new WebException("<b>HTML class error</b><br />Language not set.</b><br />
					Usage \$&lt;objectname&gt;->setLanguage(\"&lt;language&gt;\")");
			}
			
			if (isset($this->html))
			{
				$this->display();
				$this->_clearHtml();
			}
		}
		catch(WebException $e)
		{
			echo $e->getMessage();
		}
	}

}


?>