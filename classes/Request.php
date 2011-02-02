<?php

/**
* [type] file
* [name] Request.php
* [package] Utilities
* [author] Wim Paulussen
* [since] 2007-11-10
* [update] 2007-11-15 : in no value is set , return false
* [update] 2009-10-30 : ook array $_FILES meenemen
* [expl] capture POST , GET and FILES
* [todo] all input to utf8
*/

/**
* [name] Request
* [type] class
*/
class Request
{
	/**
	* [type] attribute
	* [name] request
	* [scope] private
	* [expl] array with $_POST or $_GET variables
	*/
	private $request = array();
	
	/**
	* [type] method
	* [name] __construct
	* [scope] global
	* [expl] fills the array via _initFromHttp 
	*/
	public function __construct()
	{
		$this->request = $this->_initFromHttp();
	}
	
	private function _initFromHttp()
	{
		// combine $_FILES and $_POST if $_FILES exists
		if(!empty($_FILES)) 
		{
			$file = key($_FILES);
			$file_array = $_FILES[$file];
			$filelen = sizeof($_FILES[$file]);
			$keys = array_keys($file_array);

			for($i=0;$i<$filelen;++$i)
			{
				$ar['reqfile_'.$keys[$i]] = $file_array[$keys[$i]];
			}
			
			$postkeys = array_keys($_POST);
			$postlen = sizeof($_POST);
			for($i=0;$i<$postlen;++$i)
			{
				$ar[$postkeys[$i]] = $_POST[$postkeys[$i]];
			}
			
			return $ar;
		}
			 
		if(!empty($_POST)) { return $_POST; }
		if(!empty($_GET)) { return $_GET; }
		return array();
	}
	
	public function get($name)
	{
		if(!array_key_exists($name,$this->request)) { return false; }
		return $this->request[$name];
	}
	
	public function is($name)
	{
		if(!array_key_exists($name,$this->request)) 
		{ 
			return false; 
		}
		else
		{
			return true;
		}
	}

	/*
	* [name] dump
	* [type] method
	* [expl] dumps values in $this->request array
	* [since] 2009-10-30
	*/
	public function dump()
	{
		// echo 'in dump';
		var_dump($this->request);
	}

	public function set($name,$value)
	{
		$this->reqiest[$name] = $value;
	}
}

?>
