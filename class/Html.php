<?php

/*
** [type] file
** [name] Html.php
** [author] Wim Paulussen
** [since] 2006-12-02
** [update] 2007-01-05 - removed __destruct , replaced by close
** [update] 2007-05-11 : debugged errorreporting
** [update] 2007-05-21 : documentation
** [update] 2007-09-27 : Exception handling added
** [todo] output to screen or file
** [todo] errorhandling either in or out
** [end]
*/

/*
** [class] Html
** [extend] Session
** [end]
*/

class Html extends Session
{
	/* 
	** [type] attribute
	** [name] html
	** [scope] protected
	** [expl] holds string that holds the webpage
	** [expl] via ob_end_flush can be read
	** [end]
	*/
	protected $html ='';
	/* 
	** [type] attribute
	** [name] doctype
	** [scope] private
	** [expl] on construction the following type can be set :
	** [expl] <ul><li>html4-strict</li>
	** [expl] <li>html4-loose</li>
	** [expl] <li>html4-frameset</li>
	** [expl] <li>xhtml-strict</li>
	** [expl] <li>xhtml-frameset</li>
	** [expl] <li>xhtml-loose</li></ul>
	** [end]
	*/
	private $doctype;
	/* 
	** [type] attribute
	** [name] language
	** [scope] private
	** [expl] defines language attribute in html-tag
	** [end]
	*/
	private $language;
	/* 
	** [type] attribute
	** [name] output
	** [scope] private
	** [expl] determines where the data is written
	** [expl] if empty ->output to browser
	** [expl] if set -> output to file with that name
	** [end]
	*/
	private $output;
	/* 
	** [type] attribute
	** [name] pageError
	** [scope] private
	** [expl] holds string with errors reported on page
	** [end]
	*/

	private $pageError = "---\n";
	/* 
	** [type] method
	** [name] __construct
	** [scope] global
	** [expl] output bufering started - attempt to clean the buffer with Exception
	** [end]
	*/
	public function __construct() 
	{ 
		ob_start();	
	}

	/* 
	** [type] method
	** [name] __destruct
	** [scope] global
	** [expl] end of html class
	** [end]
	*/
	/*
	public function __destruct() { echo '<!-- Class Html ended --></html>'; }
	/*
	** [type] method
	** [name] close
	** [scope] global
	** [expl] flushes the buffered output
	** [end]
	*/
	public function close()
	{
		if ($this->html != '')
		{
			$this->html .= '</html>';
		}
		else
		{
			$this->html = '</html>';
		} 
		// ob_end_flush();

		$this->display();
	}

	/*
	** [type] method
	** [name] setDoctype
	** [scope] public
	** [expl] sets the doctype declaration based on a parameter
	** [expl] <ul><li>html4-strict</li>
	** [expl] <li>html4-loose</li>
	** [expl] <li>html4-frameset</li>
	** [expl] <li>xhtml-strict</li>
	** [expl] <li>xhtml-frameset</li>
	** [expl] <li>xhtml-loose</li></ul>
	** [end]
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

	/*
	** [type] method
	** [name] setLanguage
	** [scope] public
	** [expl] sets the language for the html tag
	** [expl] e.g. setLanguage('nl')
	** [expl] 
	** [end]
	*/
	public function setLanguage($lang)
	{
		$this->language = $lang;
		$this->html .= '<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="'.$this->language.'" lang="'.$this->language.'">'."\n";
	}

	/*
	** [type] method
	** [name] build
	** [scope] public
	** [expl] returns the html output to the display function
	** [expl] ALL subclasses need to override this method
	** [end]
	*/
	public function build()
	{
		if($this->_pageError())
		{
			echo nl2br($this->pageError);
			die();
		}
		if (isset($this->html))
		{
			$this->display();
			$this->_clearHtml();
		}
	}
	
	/*
	** [type] method
	** [name] display
	** [scope] public
	** [expl] display with an 'echo' the content of the html variable
	** [expl] 
	** [end]
	*/
	public function display()
	{
		echo $this->html;
		$this->_clearHtml();
	}

	/*
	** [type] method
	** [name] dump
	** [scope] public
	** [expl] returns the data of the html variable
	** [expl] 
	** [end]
	*/
	public function dump()
	{
		$this->_temp = $this->html;
		$this->_clearHtml();
		return $this->_temp;
	}

	/*
	** [type] method
	** [name] _clear_html
	** [scope] protected
	** [expl] clears the html variable of content
	** [expl] 
	** [end]
	*/
	protected function _clearHtml()
	{
		$this->html = '';
	}

	/*
	** [type] method
	** [name] _pageError
	** [scope] private
	** [expl] [experimental] error trigging
	** [expl] 
	** [end]
	*/
	private function _pageError()
	{
		if(!isset($this->doctype))
		{
			throw new HTMLException("Doctype not set.</b><br> 
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
			throw new HTMLException("Language not set  : usage \$&lt;objectname&gt;->setLanguage(\"&lt;language&gt;\")");
		}
	}
}

/*
** [class] HtmlException
** [extend] Exception
** [end]
*/
class HtmlException extends Exception
{
	/* 
	** [type] method
	** [name] __construct
	** [scope] global
	** [expl] exception function for class HTML
	** [end]
	*/
	function __construct($eMessage)
	{
		$handlers = ob_list_handlers();
		while ( ! empty($handlers) )    
		{
			ob_end_clean();
			$handlers = ob_list_handlers();
		}
		parent::__construct('<b>[HTML class error] '.$eMessage.'<hr />');
	}
	
}
?>
