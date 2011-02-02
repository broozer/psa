<?php

/**
* [type] file
* [name] Time.php
* [package] Utilities
* [author] Wim Paulussen
* [since] 2007-11-09
* [update] 2009-10-25 myDTtoUnix all data to intval
* [todo] function descriptions
*/

/**
* [name] Time
* [type] class
*/
class Time
{
	/**
	* [type] method
	* [name] myToUnix
	* [scope] public
	* [expl] converts a MySQL date to a Unix timestamp7
	* [expl] e.g. '2004-06-09'	-> 10867320000 
	*/
	public static function myToUnix($data)
	{
		$darray		= explode("-",$data);
		return mktime(0,0,0,$darray[1],$darray[2],$darray[0]);
	}
	
	/**
	* [type] method
	* [name] dutchToUnix
	* [scope] public
	* [expl] converts a dutch date to a Unix timestamp
	* [expl] e.g. '09-06-2004'	-> 10867320000 
	*/
	public static function dutchToUnix($data)
	{
		$darray		= explode("-",$data);
		return mktime(0,0,0,$darray[1],$darray[0],$darray[2]);
	}
	/**
	* [type] method
	* [name] unixToDutch
	* [scope] public
	* [expl] given a Unix timestamp convert it to a Dutch date
	* [expl] e.g. 10867320000 	-> '09-06-2004'
	*/
	public static function unixToDutch($data)
	{
		return date("d-m-Y",$data);
	}
	/**
	* [type] method
	* [name] unixToMy
	* [scope] public
	* [expl] given a Unix timestamp convert it to a MySQL date
	* [expl] e.g. 10867320000 	-> '2004-06-09'
	*/
	public static function unixToMy($data)
	{
		return date("Y-m-d",$data);
	}
	/**
	* [type] method
	* [name] myToDUtch
	* [scope] public
	* [expl] given a MySQL date, convert it to a Dutch date
	* [expl] e.g. '2004-06-09'	-> '09-06-2004'
	*/
	public static function myToDutch($data)
	{
		$darray		= str_replace("/","-",$data);
		$darray		= explode("-",$darray);
		return $darray[2].'-'.$darray[1].'-'.$darray[0];
	}
	/**
	* [type] method
	* [name] dutchToMy
	* [scope] public
	* [expl] given a Dutch date, convert it to a MySQL date
	* [expl] e.g. '2004-06-09'	-> '09-06-2004'
	*/
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
		if(strlen($darray[2] == 2))
		{
			$darray[2] = '20'.$darray[2];
		}
		if (isset($darray[0]) && isset($darray[1]) && isset($darray[2]))
		{
			return $darray[2].'-'.$darray[1].'-'.$darray[0];
		}
	}
	/**
	* [type] method
	* [name] unixToMyDT
	* [scope] public
	* [expl] given a Unix timestamp convert it to a MySQL datetime
	*/
	public static function unixToMyDT($data)
	{
		return date("Y-m-d H:i:s",$data);
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
	/**
	* [type] method
	* [name] myDThour
	* [scope] public
	* [expl] given a Mysql DATETIME string -> give hour
	*/
	public static function myDThour($data)
	{
		$this->container = substr($data,11,2);
		return $this->container;
	}
	/**
	* [type] method
	* [name] myDTminute
	* [scope] public
	* [expl] given a Mysql DATETIME string -> give minute
	*/
	public static function myDTminute($data)
	{
		$this->container = substr($data,14,2);
		return $this->container;
	}
	/**
	* [type] method
	* [name] myDTsecond
	* [scope] public
	* [expl] given a Mysql DATETIME string -> give second
	*/
	public static function myDTsecond($data)
	{
		$this->container = substr($data,17,2);
		return $this->container;
	}
	/**
	* [type] method
	* [name] myDTyear
	* [scope] public
	* [expl] given a Mysql DATETIME string -> give year
	*/
	public static function myDTyear($data)
	{
		$this->container = substr($data,0,4);
		return $this->container;
	}
	/**
	* [type] method
	* [name] myDTmonth
	* [scope] public
	* [expl] given a Mysql DATETIME string -> give month
	*/
	public static function myDTmonth($data)
	{
		$this->container = substr($data,5,2);
		return $this->container;
	}
	/**
	* [type] method
	* [name] myDTday
	* [scope] public
	* [expl] given a Mysql DATETIME string -> give day
	*/
	public static function myDTday($data)
	{
		$this->container = substr($data,8,2);
		return $this->container;
	}

	# tijd (uren minuten)
	//{{{ unixToTime
	/**
	* function unixToTime
	*
	* given a unix timestamp, convert it to a HH-mm
	*
	*@params	string $data	unix timestamp
	*@return	string $date	HH-mm
	*/
	public static function unixToTime($data)
	{
		return date("H-i",$data);
	}
	//}}}
	//{{{ unixToTimeS
	/**
	* function unixToTimeS
	*
	* given a unix timestamp, convert it to a HH-mm
	*
	*@params	string $data	unix timestamp
	*@return	string $date	HH-mm
	*/
	public static function unixToTimeS($data)
	{
		return date("H-i-s",$data);
	}
	//}}}

	# overigen unixstamp
	//{{{ dayOfWeek returns the day of the week in numeric format
	/**
	* function dayOfWeek 
	*
	* returns day of week in numeric format (0 is sunday,6 is saturday)
	*
	*@params		string $data	unix timestamp
	*@return		string $date	number
	*/
	public static function dayOfWeek($data)
	{
		return date('w',$data);
	}
	
	//}}}
	//{{{ monthOfYear returns the month in numeric format
	/**
	* function monthOfYear
	*
	* returns month of year in numeric format (01-12)
	*
	*@params	string $data	unix timestamp
	*@return		string $date	number
	*/
	public static function monthOfYear($data)
	{
		return date('m',$data);
	}
	
	//}}}
	//{{{ yearOfUnix returns the year in numeric format
	/**
	* function yearOfUnix
	*
	* returns year in numeric format (e;g; 2004)
	*
	*@params	string $data	unix timestamp
	*@return		string $date	number
	*/
	public static function yearOfUnix($data)
	{
		return date('Y',$data);
	}
	
	//}}}
	//{{{ dayOfWeekA returns the day of the week in alfabetic format
	/**
	* function dayOfWeekA 
	*
	* returns day of week in alfabetic format
	*
	*@params	string $data	Unix timestamp
	*@return		string $day	string
	*/
	public static function dayOfWeekA($data)
	{
		return date('l',$data);
	}
	//}}}
	//{{{ weekOfYear returns the  number of the week in the year
	/**
	* function weekOfYear
	*
	* returns number of the week in the year (starting monday of the week the first Thursday of the week is in
	*
	*@params	string $data	Unix timestamp
	*@return		string $day	number
	*/
	public static function weekOfYear($data)
	{
		return date('W',$data);
	}
	//}}}
	//{{{ daysInMonth returns the  number of days in a month
	/**
	* function daysInMonth
	*
	* returns number of days in a month (including leap year)
	*
	*@params	string $data	Unix timestamp
	*@return		string $day	number
	*/
	public static function daysInMonth($data)
	{
		return date('t',$data);
	}
	//}}}
	//{{{ dayOfYear returns the  number of the given day in a year
	/**
	* function dayOfYear
	*
	* returns number of day in year
	*
	*@params	string $data	Unix timestamp
	*@return		string $day	number
	*/
	public static function dayOfYear($data)
	{
		return date('z',$data);
	}
	//}}}
	//{{{ firstDayOfMonth returns the  number of the first day of the month
	/**
	* function firstDayOfMonth
	*
	* returns number first day of month
	*
	*@params	string $data	Unix timestamp
	*@return		string $day	number
	*/
	public static function firstDayOfMonth($data)
	{
		$maand 	= date('m',$data);
		$jaar		= date('Y',$data);
		
		$darray = mktime(0,0,0,date('m',$data),1,date('Y',$data));
		return date('w',$darray);
	}
	//}}}
	//{{{ first Day of month 2 returns full Unix timestamp for first day
	/**
	* function firstDayOfMonth2
	*
	* returns unixstamp first day of month
	*
	*@params	string $data	Unix timestamp
	*@return		string $day	number
	*/
	public static function firstDayOfMonth2($data)
	{
		$maand = date('m',$data);
		$jaar		= date('Y',$data);
		
		$darray = mktime(0,0,0,date('m',$data),1,date('Y',$data));
		return $darray;
	}
	//}}}	
	//{{{ dayAddOne returns the  next day
	/**
	* function dayAddOne
	*
	* returns the  next day
	*
	*@params	string $data	Unix timestamp
	*@return		string $date	Unix timestamp
	*/
	public static function dayAddOne($data)
	{
		$darray = mktime(0,0,0,date('m',$data),date('j',$data)+1,date('Y',$data));
		return $darray;
	}
	//}}}
	//{{{ dayMinusOne returns the previous day
	/**
	* function dayMinusOne
	*
	* returns the previous day
	*
	*@params	string $data	Unix timestamp
	*@return	string $date	Unix timestamp
	*/
	public static function dayMinusOne($data)
	{
		$darray = mktime(0,0,0,date('m',$data),date('j',$data)-1,date('Y',$data));
		return $darray;
	}
	//}}}
	//{{{ dayOfMonth returns the day as a number
	/**
	* function dayOfMonth
	*
	* returns the number of the day
	*
	*@params	string $data	Unix timestamp
	*@return	string $date	day number
	*/
	public static function dayOfMonth($data)
	{
		$darray = date('j',$data);
		return $darray;
	}
	//}}}
	//{{{ weekToMonth returns the month based on a week in the year number
	/**
	* function weekToMonth
	*
	* returns the month based on the week in a year
	*
	*@params	string $data	Unix timestamp
	*@return	string $month	month number
	*/
	public static function weekToMonth($data)
	{
		die('functie weekToMonth in clsTijd.php NIET ok');
		$week = $data;
		$month = round($week/4,0); // approx
		return $month;
	}
	//}}}
	# application specific
	//{{{  geldige_dag checkt op basis van dag en maand - let op voor leap-year (voor pers)
	public static function geldige_dag($ch1,$ch2)
	{
		$ded = array("01","03","05","07","08","10","12");
		$ddd = array("04","06","09","11");
	
		if (in_array($ch2,$ded))
		{
			if (strval($ch1) <32 && strval($ch1) >0)
			{
				return TRUE;
			}
		}

		if (in_array($ch2,$ddd))
		{
			if (strval($ch1) <31 && strval($ch1) >0)
			{
				return TRUE;
			}
		}
		// geen onderscheid voor leap year -> slechts van toepassing indien 2008 eraan komt ?? 
		if ($ch2 == "02")
		{
			if (strval($ch1) <30 && strval($ch1) >0)
			{
				return TRUE;
			}
		}
	
		return FALSE;
	}
	//}}}
	//{{{  geldige_maand (voor pers)
	public static function geldige_maand($check)
	{
		$ded = array("01",'02',"03",'04',"05",'06',"07","08",'09',"10",'11',"12");
		if (in_array($check,$ded))
		{
			return TRUE;
		}
		return FALSE;
	}
	//}}}
	//{{{
	/**
	* function prevMonth
	*
	* given unix timestamp , gives date 1 month ago
	*
	*@params	string $data	Unix timestamp
	*@return	string $month	month number
	*/
	public static function prevMonth($datum)
	{
		$year	= $this->yearOfUnix($datum);
		$month = $this->monthOfYear($datum);
		$month = $month-1;
		if($month < 1)
		{
			$month = 12;
			$year = $year - 1;
		}
		$day = $this->dayOfMonth($datum);
		$prevDate = mktime(0,0,0,$month,$day,$year);
		return $prevDate;
	}
	//}}}
    /**
	* function nextMonth
	*
	* given unix timestamp , gives date 1 month ago
	*
	*@params	string $data	Unix timestamp
	*@return	string $month	month number
	*/
	public static function nextMonth($datum)
	{
		$year	= self::yearOfUnix($datum);
		$month = self::monthOfYear($datum);
		$month = $month+1;
		if($month > 12)
		{
			$month = 1;
			$year = $year + 1;
		}
		$day = self::dayOfMonth($datum);
		$nextDate = mktime(0,0,0,$month,$day,$year);
		return $nextDate;
	}
}

?>
