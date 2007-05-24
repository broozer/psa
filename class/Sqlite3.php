<?php

class Sqlite3 extends Session
{
	public $name;
	public $db;

	function __construct($name,$type=3)
	{
		$this->name	= $name;
		if($type <> 2)
		{
			// DEBUG: echo $this->name;
			if (!$this->db = new PDO('sqlite:'.$this->name))
			{
				return false;
			}
			return true;
		}
		else
		{
			// DEBUG: echo $this->name;
			// echo 'sqlite 2';
			// echo $this->name;
			if (!$this->db = new PDO('sqlite2:'.$this->name))
			{
				return false;
			}
			return true;
		}
	}

	function query($q)
	{
		if($this->rq = $this->db->query($q))
		{
			return $this->rq;
		}
		else
		{
			/*
			echo $this->db->errorCode();
			var_dump($this->db->errorInfo()); // you want [2]
			*/
			return false;
		}
	}

	function rowCount($rq)
	{
		$this->rq = $rq;
		return $this->rq->rowCount();
	}

	function fetch($rq)
	{
		$this->rq = $rq;
		return $this->rq->fetch();
	}
}

?>
