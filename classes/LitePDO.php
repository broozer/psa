<?php

/**
* [name] LitePDO.php
* [type] file
* [package] LitePDO
* [since] 2008-08-27
* [update]
* [author] Wim Paulussen
* [creation-by] pcb.php (version: 0.2 - 2008-07-16)
* [update] 2009-01-12 : extends PDO for errorreporting
* [update] 2009-01-12 : __construct public for errorreporting
* [update] 2009-08-12 : E_STRICT compliant
* [update] 2009-08-20 : resultset geactiveerd as variable
* [update] 2009-09-17 : resultset niet unsetten maar naar NULL
* [todo] setAttribute 
*/

/**
* [name] LitePDO
* [type] class
*/
class LitePDO extends PDO
{
	static $instance;
	/**
	* [name] sql
	* [type] attribute
	* [scope] public
	* [expl] connectie (singleton)
	*/
	public $sql;
	/**
	* [name] query
	* [type] attribute
	* [scope] private
	* [expl] query string that will be executed
	*/
	private $query;
	/**
	* [name] stmt
	* [type] attribute
	* [scope] private
	* [expl] statement
	*/
	private $stmt;
	/**
	* [name] bindField
	* [type] attribute
	* [scope] private
	* [expl] field that will contain the value for querying
	*/
	private $bindField;
	/**
	* [name] bindparam
	* [type] attribute
	* [scope] private
	* [expl] value that will be bound
	*/
	private $bindParam;
	/**
	* [name] result
	* [type] attribute
	* [scope] public
	* [expl] result
	*/
	public $result;
	/**
	* [name] resultset
	* [type] attribute
	* [scope] public
	* [expl] holds data in array
	*/
	public $resultset;
	/**
	* [name] dsn
	* [type] attribute
	* [scope] private
	* [expl]
	*/
	private $dsn;

	/**
	* [name] setSql
	* [type] method
	* [scope] public
	* [expl] set sql
	*/
	public function setSql($data) { $this->sql = $data; }
	/**
	* [name] setQuery
	* [type] method
	* [scope] public
	* [expl] set query
	*/
	public function setQuery($data) { $this->query = $data; }
	/**
	* [name] setStmt
	* [type] method
	* [scope] public
	* [expl] set stmt
	*/
	public function setStmt($data) { $this->stmt = $data; }
	/**
	* [name] setBindfield
	* [type] method
	* [scope] public
	* [expl] set bindfield
	*/
	public function setBindfield($data) { $this->bindField = $data; }
	/**
	* [name] setBindparam
	* [type] method
	* [scope] public
	* [expl] set bindparam
	*/
	public function setBindparam($data) { $this->bindParam = $data; }
	/**
	* [name] setResult
	* [type] method
	* [scope] public
	* [expl] set result
	*/
	public function setResult($data) { $this->result = $data; }
	/**
	* [name] setDsn
	* [type] method
	* [scope] public
	* [expl] set dsn
	*/
	public function setDsn($data) { $this->dsn = $data; }

	/**
	* [name] getSql
	* [type] method
	* [scope] private
	* [expl] get sql
	*/
	private function getSql() { return $this->sql; }
	/**
	* [name] getQuery
	* [type] method
	* [scope] private
	* [expl] get query
	*/
	private function getQuery() { return $this->query; }
	/**
	* [name] getStmt
	* [type] method
	* [scope] private
	* [expl] get stmt
	*/
	private function getStmt() { return $this->stmt; }
	/**
	* [name] getBindfield
	* [type] method
	* [scope] private
	* [expl] get bindfield
	*/
	private function getBindfield() { return $this->bindField; }
	/**
	* [name] getBindparam
	* [type] method
	* [scope] private
	* [expl] get bindparam
	*/
	private function getBindparam() { return $this->bindParam; }
	/**
	* [name] getResult
	* [type] method
	* [scope] private
	* [expl] get result
	*/
	private function getResult() { return $this->result; }
	/**
	* [name] getDsn
	* [type] method
	* [scope] private
	* [expl] get dsn
	*/
	private function getDsn() { return $this->dsn; }
	
	public function __construct($data,$user='',$pass='')
	{
		try
		{
			$this->sql = new PDO($data,$user,$pass);
			$this->sql->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); // , PDO::FETCH_OBJ);
		}
		catch(Exception $e)
		{
			echo $e->getMessage();
			die(' : no connection possible to database!');
		}
		
	}

	/* no more getInstance
	public static function getInstance($data,$user='',$pass='')
		if (!self::$instance)
		{
		    self::$instance = new LitePDO($data,$user,$pass);
		}

		return self::$instance;
	}
	*/
	
	public function qo($q)
	{
		try
		{
			$this->result = FALSE;
			
			$this->qo = $q;
			if(!$this->stmt = $this->sql->prepare($this->qo))
			{
				throw new WebException("<b>LitePDO</b><br />Query cannnot be prepared</b><br />
					Usage \$&lt;objectname&gt;->setLanguage(\"&lt;language&gt;\")");
				var_dump($this->sql->errorInfo());
				die('LitePDO query function : ERROR');
			}
			
			if(isset($this->bindField))
			{
				if(sizeof($this->bindField) > 0)
				{
					/*
					var_dump($this->bindField);
					var_dump($this->bindParam);
					*/
					
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
				throw new WebException("<b>LitePDO</b><br />Query cannnot be executed</b><br />
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

?>
