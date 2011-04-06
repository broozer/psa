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
* [update] 2011.04.06 : Exceptions works as it should (for now)
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

	/**
	* [name] __construct
	* [type] method
	* [scope] public
	* [expl] create PDO connection
	*/
	public function __construct($data,$user='',$pass='')
	{
		try
		{
			if(!$this->sql = new PDO($data,$user,$pass)) {
				throw new PDOException("<hr />LitePDO construct error<hr />");
			}
			$this->sql->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); // , PDO::FETCH_OBJ);
		}
		catch(PDOException $e)
		{
			$_SESSION['sqler'] = $e;
			return false;
		}
		
	}

	/**
	* [name] qo
	* [type] method
	* [scope] public
	* [expl] execute query
	*/
	public function qo($q)
	{
		try {
		
			$this->result = FALSE;
			$this->qo = $q;
			
			if(!$this->stmt = $this->sql->prepare($this->qo)) {
				throw new PDOException("<hr />LitePDO prepare error<hr />");
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
				throw new PDOException("<hr />LitePDO execute error<hr />");
			}
			
			$this->result = true;
			return $this->result;
		}
		catch(PDOException $e)
		{
			$_SESSION['sqler'] = $e;
			return false;
			
		}
	}

	/**
	* [name] binder
	* [type] method
	* [scope] public
	* [expl] creates array to bind parameters , needs to be called before qo
	*/
	public function binder($field,$param)
	{
		$this->bindField[] = ':'.$field;
		$this->bindParam[] = $param;
	}

	/**
	* [name] fo
	* [type] method
	* [scope] public
	* [expl] fetchObject - complete resultset , to get one row use fo_one
	*/
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

	/**
	* [name] fo_one
	* [type] method
	* [scope] public
	* [expl] returns all in one set, use when querying for one record
	*/
	public function fo_one()
	{
		return $this->stmt->fetchObject();
	}

}


?>