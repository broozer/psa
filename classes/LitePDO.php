<?php

/**
* [name] LitePDO.php
*/

class LitePDO extends PDO
{
	static $instance;
	public $sql;
	private $query;
	private $stmt;
	private $bindField;
	private $bindParam;
	public $result;
	public $resultset;
	private $dsn;

	public function setSql($data) { $this->sql = $data; }
	public function setQuery($data) { $this->query = $data; }
	public function setStmt($data) { $this->stmt = $data; }
	public function setBindfield($data) { $this->bindField = $data; }
	public function setBindparam($data) { $this->bindParam = $data; }
	public function setResult($data) { $this->result = $data; }
	public function setDsn($data) { $this->dsn = $data; }

	private function getSql() { return $this->sql; }
	private function getQuery() { return $this->query; }
	private function getStmt() { return $this->stmt; }
	private function getBindfield() { return $this->bindField; }
	private function getBindparam() { return $this->bindParam; }
	private function getResult() { return $this->result; }
	private function getDsn() { return $this->dsn; }
	
	public function __construct($data,$user='',$pass='')
	{
		try
		{
			$this->sql = new PDO($data,$user,$pass);
			$this->sql->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); // , PDO::FETCH_OBJ);
		}
		catch(LitePDOException $e)
		{
			echo $e->getMessage();
			die(' : no connection possible to database!');
		}
		
	}
	
	public static function getInstance($data,$user='',$pass='')
	{
		if (!self::$instance)
		{
		    self::$instance = new LitePDO($data,$user,$pass);
		}

		return self::$instance;
	}
	
	public function qo($q)
	{
		try
		{
			$this->result = FALSE;
			
			$this->qo = $q;
			if(!$this->stmt = $this->sql->prepare($this->qo))
			{
				throw new LitePDOException("<b>LitePDO</b><br />Query cannnot be prepared</b><br />
					Usage \$&lt;objectname&gt;->setLanguage(\"&lt;language&gt;\")");
				var_dump($this->sql->errorInfo());
				die('LitePDO query function : ERROR');
			}
			
			if(isset($this->bindField))
			{
				if(sizeof($this->bindField) > 0)
				{					
					for($i=0;$i<sizeof($this->bindField);++$i)
					{
						$this->stmt->bindParam($this->bindField[$i],$this->bindParam[$i]);
					}
					unset($this->bindField);
					unset($this->bindParam);	
				}
			}
			
			if(!$this->stmt->execute())
			{
				throw new LitePDOException("<b>LitePDO</b><br />Query cannnot be executed</b><br />
					Usage \$&lt;objectname&gt;->setLanguage(\"&lt;language&gt;\")");
				var_dump($this->sql->errorInfo());
				die('LitePDO query function : ERROR');
			}
			
			$this->result = true;
			return $this->result;
		}
		catch(WebException $e)
		{
			echo $e->getMessage();
		}
	}
	
	public function binder($field,$param)
	{
		$this->bindField[] = ':'.$field;
		$this->bindParam[] = $param;
	}
	
	public function fo()
	{
		while($row = $this->stmt->fetchObject())
		{
			$this->resultset[] = $row;
		}
		
		$resdump = $this->resultset;
		$this->resultset = NULL;
		return $resdump;
	}
	
	public function fo_one()
	{
		return $this->stmt->fetchObject();
	}

}

class LitePDOException extends Exception
{
	/** 
	* [type] method
	* [name] __construct
	* [scope] global
	* [expl] exception function for package Common
	*/
	function __construct($eMessage)
	{
		// ob_end_clean();
		parent::__construct('<div style="color: midnightblue; background-color: orange;"><hr />'.$eMessage.'<hr /></div>');
	}
	
}

?>
