<?php

/*
** [type] file
** [name] Psa.php
** [author] Wim Paulussen
** [since] 2007-05-21
** [update] 
** [todo] check public/private for attributes and methods
** [end]
*/

/*
** [class] File
** [extend] Session
*/
class Psa extends Session
{
	/* 
	** [type] attribute
	** [name] current
	** [scope] public
	** [expl] holds name of current database
	** [end]
	*/
	public $current;
	/* 
	** [type] attribute
	** [name] databases
	** [scope] public
	** [expl] holds array with databases in given directory
	** [end]
	*/
	public $databases;

	/*
	** [type] method
	** [name] __construct
	** [scope] global
	** [expl] sets current database in session variable 
	** [end]
	*/
	function __construct()
	{
		if ($this->isS('db'))
		{
			$this->_setCurrent($this->getS('db'));
		}
	}

	/*
	** [type] method
	** [name] getDb
	** [scope] public
	** [expl] gets list of databases in chosen directory and fills array
	** [expl] also checks filetype of database (2 or 3)
	** [end]
	*/
	public function getDb($datadir,$ext)
	{
        if (is_dir($datadir))
        {
			if ($dh = opendir($datadir))
			{
				while (($file = readdir($dh)) !== false)
				{
					$length_ext	= strlen($ext);
					if (substr($file,-$length_ext) == $ext)
					{
						$this->tempname = $file;
						
						$file = new File($datadir.'/'.$file);
						$file->readlines();
						$type = substr($file->line,0,15);
						// die();
						if($type == 'SQLite format 3')
						{
							$this->temptype = '3';
						}
						else if($type == '** This file co')
						{
							$this->temptype = '2';
						}
						else
						{
							$this->temptype = '0';
						}
						
						$temp['name'] = $this->tempname;
						$temp['type'] = $this->temptype; 
						$this->databases[] = $temp;
					}
				}
				closedir($dh);
				return $this->databases;
			}
			else
			{
				$this->setS('s_error','Could not open directory');
			}
		}
		else
		{
			$this->setS('s_error','Directory not existent');
    	}
    }

	/*
	** [type] method
	** [name] _setCurrent
	** [scope] private
	** [expl] assigns database as current in session handler
	*/
	private function _setCurrent($db)
	{
		$this->current = $db;
		$this->setS('db',$db);
	}

}

?>