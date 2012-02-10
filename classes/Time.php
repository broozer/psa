<?php

/**
* [type] file
* [name] Time.php
* [package] Utilities
* [author] Wim Paulussen
*/


class Time
{

	public static function myToUnix($data)
	{
		$darray		= explode("-",$data);
		return mktime(0,0,0,$darray[1],$darray[2],$darray[0]);
	}
	
	public static function dutchToUnix($data)
	{
		$darray		= explode("-",$data);
		return mktime(0,0,0,$darray[1],$darray[0],$darray[2]);
	}
	
	public static function unixToDutch($data)
	{
		return date("d-m-Y",$data);
	}
	
	public static function unixToMy($data)
	{
		return date("Y-m-d",$data);
	}
	
	public static function myToDutch($data)
	{
		$darray		= str_replace("/","-",$data);
		$darray		= explode("-",$darray);
		return $darray[2].'-'.$darray[1].'-'.$darray[0];
	}
	
	public static function dutchToMy($data)
	{
		$darray		= str_replace("/","-",$data);
		$darray		= explode("-",$darray);
		if (isset($darray[0]))
		{
			if (strlen($darray[0]) == 1)
			{
				$darray[0]	= '0'.$darray[0];
			}
		}
		if (isset($darray[1]))
		{
			if (strlen($darray[1]) == '1')
			{
				$darray[1]	= '0'.$darray[1];
			}
		}
		if(strlen($darray[2]) == 2)
		{
			$darray[2] = '20'.$darray[2];
		}
		if (isset($darray[0]) && isset($darray[1]) && isset($darray[2]))
		{
			return $darray[2].'-'.$darray[1].'-'.$darray[0];
		}
	}
	//{{{ dayOfWeek returns the day of the week in numeric format
	/**
	* function dayOfWeek 
	*
	* returns day of week in numeric format (0 is sunday,6 is saturday)
	*
	*@params		string $data	unix timestamp
	*@return		string $date	number
	*/
	public static function dayOfWeek($data)	{
		return date('w',$data);
	}

	/**
	* [type] method
	* [name] myDTtoUnix
	* [scope] public
	* [expl] given a Mysql DATETIME string -> give timestamp
	*/
	public static function myDTtoUnix($data)
	{
		$darray		= explode("-",substr($data,0,11));
		$tarray		= explode(":",substr($data,11));
		/*
		echo 'tarray 0 : '.$tarray[0].'<br />';
		echo 'tarray 1 :<b> '.$tarray[1].'</b><br />';
		echo 'darray 0 :<b> '.$darray[0].'</b><br />';
		echo 'darray 1 :<b> '.$darray[1].'</b><br />';
		echo 'darray 2 :<b> '.$darray[2].'</b><br />';
		*/
		return mktime(intval($tarray[0]),intval($tarray[1]),0,intval($darray[1]),intval($darray[2]),intval($darray[0]));
	}
	
}

?>
