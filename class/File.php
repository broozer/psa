<?php

/*
** [type] file
** [name] File.php
** [author] Wim Paulussen
** [since] 2007-05-08
** [update] 
** [todo] alles (ongeveer)
** [end]
*/

/*
** [class] File
** [extend] Session
*/
class File extends Session
{
	/* 
	** [type] attribute
	** [name] fp
	** [scope] public
	** [expl] file handle
	** [end]
	*/
	public $fp;
	/* 
	** [type] attribute
	** [name] file
	** [scope] public
	** [expl] filename
	** [end]
	*/
	public $file;
	/* 
	** [type] attribute
	** [name] mode
	** [scope] public
	** [expl] read (r) , write (w), append (a)
	** [end]
	*/
	public $mode;
	/* 
	** [type] attribute
	** [name] line
	** [scope] public
	** [expl] one line out of file
	** [end]
	*/
	public $line;
	/* 
	** [type] method
	** [name] __construct
	** [scope] global
	** [expl] tries to open file
	** [end]
	*/
	public function __construct($file,$mode='rb')
	{
		$this->file 	= $file;
		$this->mode		= $mode;
		if ($this->fp = fopen($this->file,$this->mode))
		{
			return TRUE;
		}
		else
		{
			return FALSE;
		}
	}
	
	/* 
	** [type] method
	** [name] __destruct
	** [scope] global
	** [expl] closes file via filehandle
	** [end]
	*/
	public function __destruct()
	{
		fclose($this->fp);
	}

	/* 
	** [type] method
	** [name] readlines (readline not allowed by PHP)
	** [scope] public
	** [expl] returns one line
	** [end]
	*/
	public function readlines()
	{
		if (!feof($this->fp))
		{
			$this->line =  fgets($this->fp,4096);
			return TRUE;
		}
		else
		{
			return FALSE;
		}
	}

	/* 
	** [type] method
	** [name] line_to_array
	** [scope] public
	** [todo] testen of hij de juiste lijn neemt
	** [expl] turns a line into an array by splitting via de separator
	** [end]
	*/
	public function line_to_array($sep="	")
	{
		$this->ar = explode($sep,$this->line);
		return $this->ar;
	}
	
	/* 
	** [type] method
	** [name] writelines
	** [scope] global
	** [expl] tries to write a line to a file
	** [end]
	*/
	public function writelines($data)
	{
		if(!fwrite($this->fp,$data))
        {
            return FALSE;
        }
		return TRUE;
	}
}
?>
