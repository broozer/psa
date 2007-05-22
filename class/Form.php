<?php

/*
** [type] file
** [name] Form.php
** [author] Wim Paulussen
** [since] 2007-01-11
** [update] 2007-01-18 : debug error
** [update] 2007-01-23 : reset setName en Settarget voor validatie
** [update] 2007-04-01 : target debugged voor jade
** [todo] testing setEnctype / setTarget
** [todo] 
** [end]
*/

/*
** [class] Form
** [extend] Body
** [extend] Html
** [extend] Session
** [end]
*/
class Form extends Body
{
	/* 
	** [type] attribute
	** [name] _action
	** [scope] private
	** [expl] file (url) that needs to be executed
	** [end]
	*/
	private $_action	= '';
	/* 
	** [type] attribute
	** [name] _method
	** [scope] private
	** [expl] either POST or GET (standard = POST)
	** [end]
	*/
	private $_method	= 'post';
	/* 
	** [type] attribute
	** [name] _target
	** [scope] private
	** [expl] standard = _self
	** [end]
	*/
	private $_target	= '_self';
	/* 
	** [type] attribute
	** [name] _enctype
	** [scope] private
	** [expl] standard NULL
	** [end]
	*/
	private $_enctype	= NULL;
	/*
	** [type] method
	** [name] setAction
	** [scope] public
	** [expl] sets file to execute
	** [end]
	*/
	public function setAction($data) 	
	{ 
		if (!file_exists($data))
		{
			$this->setS('s_error','File for FORM redirection does not exist');
			return FALSE;
		}
		$this->_action	= $data; 
	}
	
	/*
	** [type] method
	** [name] setEnctype
	** [scope] public
	** [expl] sets _enctype
	** [end]
	*/
	public function setEnctype($data) { $this->_enctype = $data; }
	/*
	** [type] method
	** [name] setTarget
	** [scope] public
	** [expl] sets _target
	** [end]
	*/
	public function setTarget($data) 
	{ 
		$this->_target = $data;
	}
	/*
	** [type] method
	** [name] setMethod
	** [scope] public
	** [expl] sets _method
	** [end]
	*/
	public function setMethod($data)	
	{ 
		if ($data != 'post' && $data != 'get')
		{
			$this->setS('s_error','Method for FORM is either get or post');
			return FALSE;
		}
		$this->_method = $data;
		return TRUE;
	}
	
	/*
	** [type] method
	** [name] build
	** [scope] public
	** [expl] after all tags are set , you run this function
	** [end]
	*/
	function build()
	{
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
		$this->display();
	}
	/*
	** [type] attribute
	** [name] close
	** [scope] public
	** [expl] gives 'final' tag
	** [end]
	*/
	public function close()
	{
		$this->html = "</form>\n";
		$this->display();
	}
}
?>