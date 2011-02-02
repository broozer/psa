<?php

/**
* [type] file
* [name] Session.php
* [author] Wim Paulussen
* [package] Utilities
* [since] 2006-12-02
* [update] 2006-12-03 : documentation
* [update] 2007-05-15 : new parsedoc parameters
* [todo] none
* [package] web
*/

/**
* [type] class
* [name] Session
* [expl] to start a Session
*/
class Session
{
	/**
	* [type] attribute
	* [name] instance
	* [scope] private
	* [expl] placeholder for session starter
	*/
	private static $instance;
	/**
	* [type] attribute
	* [name] name
	* [scope] private
	* [expl] holds name set in session
	*/
	private $name;
	/** 
	* [type] attribute
	* [name] value
	* [scope] private
	* [expl] holds value set in session
	*/
	private $value;
	/**
	* [type] method
	* [name] __construct
	* [scope] global
	* [expl] check existence of variable 
	* [expl] $_SESSION if it does not exist , start session
	*/
	
	public function __construct()
	{
		if(!isset($_SESSION))
		{
			session_start();
		}
	}
	
    /**
	* [type] method
	* [name] setS
	* [scope] public
	* [expl] setting a value in $_SESSION 
	* [expl] usage : $session->setS(name,value)
	*/
    public function setS($name,$value)
    {
	$this->name = $name;
	$this->value = $value;
        $_SESSION[$this->name] = $this->value;
    }
	/**
	* [type] method
	* [name] getS
	* [scope] public
	* [expl] gets a value in $_SESSION based on provided name
	* [expl] usage : $session->getS(name)
	*/
    public function getS($name)
    {
		$this->name = $name;
		if ($this->isS($this->name))
		{
 	       return $_SESSION[$this->name];
		}
		return FALSE;
    }
	/**
	* [type] method
	* [name] unsetS
	* [scope] public
	* [expl] removes a value in $_SESSION based on provided name
	* [expl] usage : $session->unsetS(name)
	*/
    public function unsetS($name)
    {
		$this->name = $name;
		if ($this->isS($this->name))
		{
        	unset($_SESSION[$this->name]);
    	}
		return FALSE;
	}
  	/**
	* [type] method
	* [name] isS
	* [scope] public
	* [expl] checks whether a value is set
	* [expl] in $_SESSION based on provided name
	* [expl] usage : $session->isS(name)
	*/
    public function isS($name)
    {
		$this->name = $name;
	    if (isset($_SESSION[$this->name]))
	    {
		    return TRUE;
	    }
	    else
	    {
		    return FALSE;
	    }
    }
}

?>