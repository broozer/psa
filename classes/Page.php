<?php

/**
* [name] Page.php
* [since] 2011.05.28
*/

class Page extends Base
{
	private $doctype = '<!doctype html>';
	private $language = 'en';
	public static $html_set = FALSE;
	public static $head_set = FALSE;
	public static $body_set = 0;
    public static $debug = 0;
	
	public function __construct() 
	{ 
		self::$html_set = TRUE;
        $this->html = $this->doctype."\n";
	}

	public static function getHtml_set()
	{
		if(self::$html_set)
		{
			return true;
		}
		return false;
	}
	
	public static function getHead_set()
	{
		if(self::$head_set)
		{
			return true;
		}
		return false;
	}
	
	public static function getBody_set() {
		if(self::$body_set) {
			return true;
		}
		return false;
	}
	
	public function setOutput($data)
	{
		self::$isOutput = TRUE;
		self::$outputFile = $data;
	}
	
	public function __destruct()
	{
		try
		{
			if(!self::$html_set || !self::$head_set) {
				
				throw new PageException("<b>HTML class exception.</b><br />Either &lt;html&gt; or &lt;head&gt; or &lt;body&gt; is not set.</b><br />
					All these tags need to be used in order to generate valid html forms.");
			}
			
			self::$output .= "</body>\n</html>";

            if(self::$debug) {
                echo '<b>Tidy messages</b><br />';
				$tidy = tidy_parse_string(self::$output);
				echo nl2br(htmlentities(tidy_get_error_buffer($tidy)));
                echo '<hr />';
                $linedump = explode("\n",nl2br(htmlentities(str_replace("<br />","\n",self::$output))));
                // var_dump($linedump);
                
                for($i=0;$i<sizeof($linedump);++$i) {
                    if(trim(str_replace("<br>","",$linedump[$i])) == '') {
                        continue;
                    }
                    $il = strlen($i);
                    $il4 = 4-$il;
                    $j = $i+1;
                    $linenr = str_repeat("&nbsp;",$il4).$j;
                    echo $linenr.' : '.$linedump[$i];
                }
                echo '<hr />';
                self::$output = '';
                
            } else {
                echo self::$output;
                self::$output = '';
            }
		}
		catch(PageException $e)
		{
			echo $e->getMessage();
		}
	}

	public function setLanguage($lang)
	{
		
		$this->language = $lang;		
	}

	
	public function build()
	{
		try
		{
					
			if(!isset($this->language))
			{
				throw new PageException("<b>HTML class error</b><br />Language not set.</b><br />
					Usage \$&lt;objectname&gt;->setLanguage(\"&lt;language&gt;\")");
			}
            $this->html .= '<html lang="'.$this->language.'">';
			
			if (isset($this->html))
			{
				$this->display();
				$this->_clearHtml();
			}
		}
		catch(PageException $e)
		{
			echo $e->getMessage();
		}
	}

}


?>
