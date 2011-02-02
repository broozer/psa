<?php

/**
* [name] Parse.php
* [type] file
* [package] Utilities
* [expl] parsing of CMS entered test
* [update] 2007-01-18 - set foto directory
* [update] 2009-02-03 : naar Parse 
*/

class Parse extends Session
{
	public $scan;
	public $scanresult = ' ';
	public $scanpictdir = './img/';


	function scan($data)
	{
		echo 'data : '.$data.'<hr />';
		
		$this->scanresult = ' ';
		$this->scan = nl2br($data);
		$this->scanmail();
		$this->scanlink();
		$this->scanpict();
		$this->scanvet();
		$this->scancenter();
		$this->scanlist();
		$this->scanlistitem();
		echo $this->scanresult.'<hr />';
		return $this->scanresult;
	}
	
	function scanmail()
	{
		while(strpos($this->scan,'[email]') != FALSE)
		{
			$where = strpos($this->scan,'[email]');
			$this->scanresult .= substr($this->scan,0,$where);
			$this->scan = substr($this->scan,$where);
			$end 	= strpos($this->scan,'[/]');
			$email = substr($this->scan,7,$end-7);
			$this->scanresult .= '<a href="mailto:'.$email.'">'.$email.'</a> ';
			$this->scan = substr($this->scan,$end+3);
		}
		$this->scanresult .= $this->scan;
	}
	
	function scanlink()
	{
		$this->scan = $this->scanresult;
		// scannen op [link]
		$this->scanresult = '';
		while(strpos($this->scan,'[link]') != FALSE)
		{
			$where = strpos($this->scan,'[link]');
			$this->scanresult .= substr($this->scan,0,$where);
			$this->scan = substr($this->scan,$where);
			$end 	= strpos($this->scan,'[/]');
			$email = substr($this->scan,6,$end-6);
			$this->scanresult .= '<a href="http://'.$email.'">'.$email.'</a> ';
			$this->scan = substr($this->scan,$end+3);
		}
		$this->scanresult .= $this->scan;
	}
	
	function scanpict()
	{
		$this->scan = $this->scanresult;
		// scannen op [pict]
		$this->scanresult = '';
		while(strpos($this->scan,'[pict]') != FALSE)
		{
			$where = strpos($this->scan,'[pict]');
			$this->scanresult .= substr($this->scan,0,$where);
			$this->scan = substr($this->scan,$where);
			$end 	= strpos($this->scan,'[/]');
			$email = substr($this->scan,6,$end-6);
			$this->scanresult .= '<img src="'.$this->scanpictdir.$email.'" />';
			$this->scan = substr($this->scan,$end+3);
		}
		$this->scanresult .= $this->scan;
	}
	
	function scanvet()
	{
		$this->scan = $this->scanresult;
		// scannen op [vet]
		$this->scanresult = '';
		while(strpos($this->scan,'[vet]') != FALSE)
		{
			$where = strpos($this->scan,'[vet]');
			echo '<hr />[vet] gevonden !!!.<hr />';
			$this->scanresult .= substr($this->scan,0,$where);
			$this->scan = substr($this->scan,$where);
			$end 	= strpos($this->scan,'[/]');
			$email = substr($this->scan,5,$end-5);
			$this->scanresult .= '<b>'.$email.'</b>';
			$this->scan = substr($this->scan,$end+3);
		}
		$this->scanresult .= $this->scan;
	}
	
	function scancenter()
	{
		$this->scan = $this->scanresult;
		// scannen op [center]
		$this->scanresult = '';
		while(strpos($this->scan,'[center]') != FALSE)
		{
			$where = strpos($this->scan,'[center]');
			$this->scanresult .= substr($this->scan,0,$where);
			$this->scan = substr($this->scan,$where);
			$end 	= strpos($this->scan,'[/]');
			$email = substr($this->scan,8,$end-8);
			$this->scanresult .= '<center>'.$email.'</center>';
			$this->scan = substr($this->scan,$end+3);
		}
		$this->scanresult .= $this->scan;
	}
	
	function scanlist()
	{
		$this->scan = $this->scanresult;
		// scannen op [list]
		$this->scanresult = '';
		while(strpos($this->scan,'[list]') != FALSE)
		{
			$where = strpos($this->scan,'[list]');
			$this->scanresult .= substr($this->scan,0,$where);
			$this->scan = substr($this->scan,$where);
			$end 	= strpos($this->scan,'[/]');
			$email = substr($this->scan,5,$end-5);
			$this->scanresult .= '<ul>'.$email.'</ul>';
			$this->scan = substr($this->scan,$end+3);
		}
		$this->scanresult .= $this->scan;
	}
	
	function scanlistitem()
	{
		$this->scan = $this->scanresult;
		// scannen op [list]
		$this->scanresult = '';
		while(strpos($this->scan,'[*]') != FALSE)
		{
			$where = strpos($this->scan,'[*]');
			$this->scanresult .= substr($this->scan,0,$where);
			$this->scan = substr($this->scan,$where);
			$end 	= strpos($this->scan,'[/]');
			$email = substr($this->scan,2,$end-2);
			$this->scanresult .= '<li>'.$email.'</li>';
			$this->scan = substr($this->scan,$end+3);
		}
		$this->scanresult .= $this->scan;
	}
}
