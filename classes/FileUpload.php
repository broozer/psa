<?php

/*
** [file] FileUpload.php
** [author] Wim Paulussen
** [since] 2008-07-10
** [update]
** [todo] alles (ongeveer)
** [end]
*/

/*
bedoeling hiermee is om file uploads te regelen via een class
1 __construct (post,nieuwe naam)

post : naam van de variable in Files welke bestand bevat
nieuwe naam : naam waarnaar het moet

*/
/*
** [class] FileUpload
** [extend] Session
*/
class FileUpload extends Session
{
	/**
	* [name] _tempname
	* [type] attribute
	* [scope] private
	* [expl]
	*/
	private $_tempname;
	/**
	* [name] _postval
	* [type] attribute
	* [scope] private
	* [expl]
	*/
	private $_postval;
	/**
	* [name] _newname
	* [type] attribute
	* [scope] public
	* [expl]
	*/
	private $_newname;
	/**
	* [name] _target
	* [type] attribute
	* [scope] private
	* [expl]
	*/
	private $_target;

	/**
	* [name] set_tempname
	* [type] method
	* [scope] public
	* [expl] set _tempname
	*/
	public function set_tempname($data) { $this->_tempname = $data; }
	/**
	* [name] set_postval
	* [type] method
	* [scope] public
	* [expl] set _postval
	*/
	public function set_postval($data) { $this->_postval = $data; }
	/**
	* [name] set_newname
	* [type] method
	* [scope] public
	* [expl] set _newname
	*/
	public function set_newname($data)  { $this->_newname = $data; }
	/**
	* [name] set_target
	* [type] method
	* [scope] public
	* [expl] set _target
	*/
	public function set_target($data)
	{
		if(!is_dir($data))
		{
			throw new FUException('Directory <b>'.$data.'</b> bestaat niet;');
		}
		$this->_target = $data;
	}

	/**
	* [name] get_tempname
	* [type] method
	* [scope] private
	* [expl] get _tempname
	*/
	private function get_tempname() { return $this->_tempname; }
	/**
	* [name] get_postval
	* [type] method
	* [scope] private
	* [expl] get _postval
	*/
	private function get_postval() { return $this->_postval; }
	/**
	* [name] get_newname
	* [type] method
	* [scope] private
	* [expl] get _newname
	*/
	public function get_newname() { return $this->_newname; }
	/**
	* [name] get_target
	* [type] method
	* [scope] private
	* [expl] get _target
	*/
	private function get_target() { return $this->_target; }

	/*
	$data -> naam van het input veld
	
	bvb indien $bestand->setName('vkf_file');
	dan $data = vkf_file
	
	*/
	public function __construct($data,$target='./uploads')
	{
		try
		{
			if($_FILES[$data]['error'] > 0)
			{
				throw new FUException("Error message op inladen door PHP - ".$_FILES["file"]["error"]);
			}
			if(!isset($_FILES[$data]))
			{
				throw new FUException("Geen gegevens in FILES");
			}
			$this->set_tempname($_FILES[$data]["tmp_name"]);

			// echo '<hr />';
			// echo $_FILES[$data]["name"];
			$this->set_newname(str_replace(" ","_",$_FILES[$data]["name"]));
			$this->set_postval($_FILES[$data]);
			$this->set_target($target);
			// echo '<hr />';
			if(!
				move_uploaded_file(
					$_FILES[$data]["tmp_name"],
					$this->get_target().'/'.$this->get_newname()))
			{
					throw new FUException("Upload niet gelukt");
			}
		}
		catch (FUException $e)
		{
				echo '<b> '.$e.'<hr />';
		}
	}

}

/**
* [name] FUException
* [type] class
* [extend] Exception
*/
class FUException extends Exception
{
	/**
	* [type] method
	* [name] __construct
	* [scope] global
	* [expl] exception function for class HTML

	*/
	function __construct($eMessage)
	{
		/*
		$handlers = ob_list_handlers();
		while ( ! empty($handlers) )
		{
			ob_end_clean();
			$handlers = ob_list_handlers();
		}
		* */
		parent::__construct('<b>[File upload class error] '.$eMessage.'<hr />');
	}

}

?>
