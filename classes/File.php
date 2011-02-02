<?php

/*
** [file] File.php
** [author] Wim Paulussen
** [since] 2007-05-08
** [update] 2009-03-02 rewinder added
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
	** [var] fp
	** [scope] public
	** [expl] file handle
	** [end]
	*/
	public $fp;
	/* 
	** [var] file
	** [scope] public
	** [expl] filename
	** [end]
	*/
	public $file;
	/* 
	** [var] mode
	** [scope] public
	** [expl] read (r) , write (w), append (a)
	** [end]
	*/
	public $mode;
	/* 
	** [var] line
	** [scope] public
	** [expl] one line out of file
	** [end]
	*/
	public $line;

	/* 
	** [function] __construct
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
	** [function] __destruct
	** [scope] global
	** [expl] closes file via filehandle
	** [end]
	*/
	public function __destruct()
	{
		fclose($this->fp);
	}

	/* 
	** [function] readlines
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
	** [function] line_to_array
	** [scope] public
	** [expl] turns a line into an array by splitting via de separator
	** [end]
	*/
	public function line_to_array($sep="	")
	{
		$this->ar = explode($sep,$this->line);
		return $this->ar;
	}
	
	/* 
	** [function] writeline
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

    /*
	** [function] rewinder
	** [scope] global
	** [expl] returns file pointer to start
	** [end]
	*/
    public function rewinder()
	{
		rewind($this->fp);
	}
}
?>
