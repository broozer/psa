<?php

/**
 * [file] File.php
 * [author] Wim Paulussen
 * [since] 2007-05-08
 * [update] 2009-03-02 rewinder added
 */

/**
 * [class] File
 * [extend] Session
 */
class File extends Session
{
	/**
	 * [var] fp
	 * [scope] public
	 * [expl] file handle
	 */
	public $fp;
	/**
	 * [var] file
	 * [scope] public
	 * [expl] filename
	 */
	public $file;
	/**
	 * [var] mode
	 * [scope] public
	 * [expl] read (r) , write (w), append (a)
	 */
	public $mode;
	/**
	 * [var] line
	 * [scope] public
	 * [expl] one line out of file
	 */
	public $line;

	/**
	 * [function] __construct
	 * [scope] global
	 * [expl] tries to open file
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
	
	/**
	 * [function] __destruct
	 * [scope] global
	 * [expl] closes file via filehandle
	 */
	public function __destruct()
	{
		fclose($this->fp);
	}

	/**
	 * [function] readlines
	 * [scope] public
	 * [expl] returns one line
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

	/**
	 * [function] line_to_array
	 * [scope] public
	 * [expl] turns a line into an array by splitting via de separator
	 */
	public function line_to_array($sep="	")
	{
		$this->ar = explode($sep,$this->line);
		return $this->ar;
	}
	
	/**
	 * [function] writeline
	 * [scope] global
	 * [expl] tries to write a line to a file
	 */
	public function writelines($data)
	{
		if(!fwrite($this->fp,$data))
        {
            return FALSE;
        }
		return TRUE;
	}

    /**
	 * [function] rewinder
	 * [scope] global
	 * [expl] returns file pointer to start
	 */
    public function rewinder()
	{
		rewind($this->fp);
	}
}