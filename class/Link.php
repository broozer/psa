<?php

/*
** [type] file
** [name] Link.php
** [author] Wim Paulussen
** [since] 2007-01-10
** [update] 2007-01-23 : validation on target
** [update] 2007-03-25 : added setJs / getJs
** [update] 2007-05-22 : added get/setClas (inherited from Body)
** [todo] all
** [end]
*/

/*
** [type] class
** [name] Link
** [extend] Body
** [extend] Html
** [extend] Session
*/
class Link extends Body
{
	/*
	** [type] attribute
	** [name] _href
	** [scope] private
	** [expl] url to link to
	** [end]
	*/
	private $_href = '';
	/* 
	** [type] attribute
	** [name] _target
	** [scope] private
	** [expl] blank , window name - standard = _self
	** [end]
	*/
	private $_target = '';
	/* 
	** [type] attribute
	** [name] _error
	** [scope] private
	** [expl] error handling (needs update)
	** [end]
	*/
	private $_error = '';
	/* 
	** [type] attribute
	** [name] _js
	** [scope] private
	** [expl] add javascript
	** [end]
	*/
	private $_js = '';
	/* 
	** [type] attribute
	** [name] _class
	** [scope] private
	** [expl] add class
	** [end]
	*/
	private $_class = '';

	// sets
	/*
	** [type] method
	** [name] setHref
	** [scope] public
	** [expl] sets href
	** [end]
	*/
	public function setHref($data) { $this->_href = $data ;}
	/*
	** [type] method
	** [name] setTarget
	** [scope] public
	** [expl] sets target (_blank, _self, <windowname>)
	** [end]
	*/
	public function setTarget($data) { $this->_target = $data ;}
	/*
	** [type] method
	** [name] setError
	** [scope] private
	** [expl] sets error handler
	** [end]
	*/
	private function setError($data) { $this->error .= $data; }
	/*
	** [type] method
	** [name] setJs
	** [scope] private
	** [expl] sets javascript command
	** [end]
	*/
	public function setJs($data) { $this->_js .= $data; }
	// gets
	/*
	** [type] method
	** [name] getHref
	** [scope] private
	** [expl] returns href set
	** [end]
	*/
	private function getHref() { return $this->_href; }
	/*
	** [type] method
	** [name]getTarget
	** [scope] private
	** [expl] returns the target
	** [end]
	*/
	private function getTarget() { return $this->_target; }
	/*
	** [type] method
	** [name] getError
	** [scope] private
	** [expl] basic error handling
	** [end]
	*/
	private function getError() { return $this->_error; }
	/*
	** [type] method
	** [name] getJs
	** [scope] private
	** [expl] javascript get string
	** [end]
	*/
	public function getJs() { return $this->_js; }
	/*
	** [type] method
	** [name] getKlasse
	** [scope] public
	** [expl] get _class
	** [end]
	*/
	function build()
	{
		if ($this->getHref() == '')
		{
			$this->setError("Href waarde niet gezet , programma gestopt.<br>");
		}

		if ($this->getTarget() == '')
		{
			$this->_target = "_self";
		}
		else
		{
			$this->_target	= $this->getTarget();
		}

		if ($this->getName() == '')
		{
			$this->setError("Geen waarde gezet voor display link.<br>");
		}

		if ($this->getError() == "")
		{
			$toHtml = '<a href="'.$this->getHref().'" ';
			$adder = '';
			
			if ($this->_target != "_self")
			{
				$adder .= '" target="'.$this->_target.'" ';
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
			$this->display();
		
		}
		else
		{
			die ($this->getError());
		}
	}	
	
	/*
	** [type] method
	** [name] dump
	** [scope] public
	** [expl] returns the html-string istead of printing it
	** [end]
	*/
	public function dump()
	{
		if ($this->getHref() == '')
		{
			$this->setError("Href waarde niet gezet , programma gestopt.<br>");
		}

		if ($this->getTarget() == '')
		{
			$this->_target = "_self";
		}
		else
		{
			$this->_target	= $this->getTarget();
		}

		if ($this->getName() == '')
		{
			$this->setError("Geen waarde gezet voor display link.<br>");
		}

		if ($this->getError() == "")
		{
			$toHtml = '<a href="'
				.$this->getHref()
				.'" target="'
				.$this->_target;
				
			if ($this->getID() != "")
			{
				$toHtml = $toHtml
				.'" id="'
				.$this->getId();
			}
			
			if ($this->getJs() != "")
			{
				$toHtml = $toHtml.'" '.$this->getJs();
			}
			
			if ($this->getClas() != '')
			{
				$toHtml = $toHtml.'" class="'.$this->getClas();
			}
			
			$toHtml = $toHtml
			.'">'
			.$this->getName()
			.'</a>';
			
			$this->html = $toHtml;
			return $this->html;
		
		}
		else
		{
			die ($this->getError());
		}
	}	
}

?>
