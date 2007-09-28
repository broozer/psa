<?php

/*
** [type] file
** [name] Body.php
** [author] Wim Paulussen
** [since] 2006-12-22
** [update] 2007-01-05 : removed __destruct , replaced by close
** [update] 2007-05-21 : documentation
** [update] 2007-09-27 : Exception handling added
** [todo] 
** [end]
*/

/*
** [class] Body
** [extend] Html
*/

class Body extends Html
{
	/* 
	** [type] attribute
	** [name] id
	** [scope] public
	** [expl] id attribute to tag
	** [end]
	*/
	public $id	= '';
	/* 
	** [type] attribute
	** [name] clas
	** [scope] public
	** [expl] clas attribute to tag
	** [end]
	*/
	public $clas	= '';
	/* 
	** [type] attribute
	** [name] js
	** [scope] public
	** [expl] js attribute for putting javascript functions in place
	** [end]
	*/
	public $js	= '';
	/* 
	** [type] attribute
	** [name] name
	** [scope] public
	** [expl] name (table,input...)
	** [end]
	*/
	public $name; //	= '';
	
	// public function __destruct() { echo '<!-- body destruct --></body>'; }
	
	/*
	** [type] method
	** [name] setJs
	** [scope] public
	** [expl] set Js content
	** [end]
	*/
	public function setJs($data) { $this->js = $data; }
	/*
	** [type] method
	** [name] setId
	** [scope] public
	** [expl] set Id
	** [end]
	*/
	public function setId($data) { $this->id = $data; }
	/*
	** [type] method
	** [name] setClas
	** [scope] public
	** [expl] set class for element 
	** [end]
	*/
	public function setClas($data) { $this->clas = $data; }
	/*
	** [type] method
	** [name] setName
	** [scope] public
	** [expl] sets name for element
	** [end]
	*/
	function setName($data) { $this->name = $data; }
	/*
	** [type] method
	** [name] getJs
	** [scope] public
	** [expl] returns js value set
	** [end]
	*/
	public function getJs() {return $this->js; }
	/*
	** [type] method
	** [name] getName
	** [scope] public
	** [expl] returns Name
	** [end]
	*/
	public function getName() { return $this->name; }
	/*
	** [type] method
	** [name] getId
	** [scope] public
	** [expl] returns Id content
	** [end]
	*/
	public function getId() { return $this->id; }
	/*
	** [type] method
	** [name] getClas
	** [scope] public
	** [expl] returns class content
	** [end]
	*/
	public function getClas() { return $this->clas; }
	
	/*
	** [type] method
	** [name] build
	** [scope] public
	** [expl] after all tags are set , you run this function
	** [end]
	*/
	public function build()
	{
		// throw new BodyException("Just for the fun of it.");
		$this->html = '<body ';
		
		if ($this->id != '')
		{
			$this->html .= ' id="'.$this->getId().'" ';
		}
		
		if ($this->js != '')
		{
			$this->html .= $this->getJs();
		}
		
		$this->html .= ">\r\n";

		$this->display();
	}
	
	/*
	** [type] method
	** [name] close
	** [scope] public
	** [expl] ends body rendering // inherited error handling with s_error
	** [expl] deprecated ?? with new Exception class ??
	** [end]
	*/
	public function close()
	{
		// $this->_checker();
		$this->html = "</body>\r\n";
		$this->display();
	}
	
	/*
	** [type] method
	** [name] _checker
	** [scope] private 
	** [expl] if a page sets a 's_error' SESSION variable, the text will be
	** [expl] on display here via a javascript alert-function
	** [end]
	*/
	private function _checker()
	{
		if (isset($_SESSION['s_error']))
		{
			if (!$_SESSION['s_error'] == '')
			{
				$this->html = '<script type="text/javascript">';
				$this->html .= 'alert("'.$this->getS('s_error').'");';
				$this->html .= '</script>';
				echo $this->html;
				$this->setS('s_error','');
			}
		}
	}
	
	/*
	** [type] method
	** [name] line
	** [scope] public
	** [expl] echo function for direct html input
	** [expl] will return a CRLF if no argument is given
	** [end]
	*/
	public function line()
	{
		$numargs	= func_num_args();
		if ($numargs > 0)
		{
			$this->html = func_get_arg(0)."\n";
		}
		else
		{
			$this->html = "<br />\n";
		}
		$this->display();
	}
}

/*
** [class] BodyException
** [extend] Exception
** [end]
*/
class BodyException extends Exception
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
		parent::__construct('<h2>[Body class error] '.$eMessage.'</h2><hr />');
	}
	
}
?>