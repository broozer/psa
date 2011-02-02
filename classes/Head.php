<?php

/**
* [name] Head.php
* [type] file 
* [package] Web
* [author] Wim Paulussen
* [since] 2006-12-19
* [update] 2007-06-09 : added css media type (standard all)
* [update] 2007-11-09 : closing procedure in line with rest
* [update] 2009-01-16 : Exception
* [update] 2009-01-16 : setCharset added
* [todo] testing
*/

/**
* [name] Head
* [type] class
* [extend] Web
*/
class Head extends Web
{
	/** 
	* [name] arMeta
	* [type] attribute
	* [scope] private
	* [expl] array for holding meta-data info
	*/
    private $arMeta;
	/** 
	* [name] pointerMeta
	* [type] attribute
	* [scope] private
	* [expl] keeps size of arMeta array
	*/
    private $pointerMeta = 0;
	/** 
	* [name] charset
	* [type] attribute
	* [scope] private
	* [expl] charset
	*/
    private $charset;
	/** 
	* [name] css
	* [type] attribute
	* [scope] private
	* [expl] variable containg name of css file to include
	*/
    private $css;
	/** 
	* [name] js
	* [type] attribute
	* [scope] private
	* [expl] variable for inclusion of javasript files
	*/
    public $js;
	/** 
	* [name] title
	* [type] attribute
	* [scope] private
	* [expl] variable for title field - defaults to 'no title'
	*/
    private $title;
	/** 
	* [name] text
	* [type] attribute
	* [scope] private
	* [expl] variable for text field
	*/
    private $text = '';

	/**
	* [name] __construct
	* [type] method
	* [scope] public (inherited)
	* [expl] checks whether html is allready set and sets Html head_set
	*/
    function __construct()
    {
		try
		{
			if(!Html::getHtml_set())
			{
				throw new WebException("<b>Head class exception</b><br>Html tag is not yet defined.</b><br> 
				  Please define &lt;html&gt; tag first.");
			}
		}
		catch(WebException $e)
		{
			echo $e->getMessage();
		}
		Html::$head_set = TRUE;
	}
	
	/**
	* [name] build
	* [type] method
	* [scope] public
	* [expl] after all tags are set , you run this function
	*/
    public function build()
    {
		try
		{
			$this->html .="
<head>
<meta http-equiv=\"Pragma\" content=\"no-cache\" />
<meta name=\"engine\" content=\"Web - asgc 2009 - version 3\" />\n";

			// $this->html .= '';
	
			 if (isset($this->charset))
			{
				$this->html     .= "<meta http-equiv=\"content-type\" content=\"text/html; charset=".$this->charset."\" />\n";
	
			}
			else
			{
				throw new WebException("<b>Head class exception</b><br>Charset not set.</b><br> 
				  Usage \$&lt;objectname&gt;->setCharset(\"&lt;charset - name&gt;\")");
				
			}
			
			if (isset($this->arMeta))
			{
				for ($i=0;$i<sizeof($this->arMeta);++$i)
				{
					$this->html     .= '<meta name="'.$this->arMeta[$i]['name'].'" content="'.$this->arMeta[$i]['content'].'" />'."\n";
				}
			}
	
			
			if ($this->title)
			{
				$this->html .= $this->title;
			}
			else
			{
				$this->html .="<title>No title</title>\n";
			}
			
			if (isset($this->css))
			{
				$this->html     .= $this->css;
			}
	
			if (isset($this->js))
			{
				$this->html     .= $this->js;
			}

			if ($this->text !== '')
			{
				$this->html     .= $this->text;
			}
	
			$this->html .= "</head>\n";
			$this->display();
		}
		catch(WebException $e)
		{
			echo $e->getMessage();
		}
    }

    /**
	* [name] setMeta
	* [type] method
	* [scope] public
	* [expl] use to fill meta-array
	* [expl] $this->setMeta('name',<your name>);
	*/
    public function setMeta($name='',$content='')
    {
		try
		{
			if ($name == '' || $content == '')
			{

				throw new WebException("<b>Head class exception</b><br /> 'name' or 'content' not set in setMeta.</b><br> 
				   The function requires that the 'name' and 'content' portion are set.");
			}

			if (isset($this->arMeta))
			{
				$this->pointerMeta    = sizeof($this->arMeta);
			}
			
			$this->arMeta[$this->pointerMeta]['name']    = $name;
			$this->arMeta[$this->pointerMeta]['content']    = $content;
			return TRUE;
		}
		catch(WebException $e)
		{
			echo $e->getMessage();
		}
		
	}

	 /**
	* [name] setCharset
	* [type] method
	* [scope] public
	* [expl] set charset
	* [expl] $this->setCharset(<name of charset>);
	*/
	public function setCharset($data='')
    {
		try
		{
			if ($data == '')
			{
	
				throw new WebException("<b>Head class exception</b><br />Charset cannot be blank.</b><br> 
				   Choose a relevant charset.");
			}
			$this->charset = $data;
		}
		catch(WebException $e)
		{
			echo $e->getMessage();
		}
    }
	
	/**
	* [name] setCss
	* [type] method
	* [scope] public
	* [expl] use to set a css file
	* [expl] $this->setCss(<filename>);
	*/
    public function setCss($file,$media="all")
    {
		try
		{
			if (file_exists($file))
			{
				$this->css .= '<link href="'.$file.'" rel="stylesheet" type="text/css" ';
	
				if($media != "all")
				{
					$this->css .= ' media="'.$media.'" ';
				}
	
				$this->css .= '/>'."\n";
				return TRUE;
			}
			else
			{
			   throw new WebException("<b>Head class exception</b><br />CSS file not found.</b><br> 
				   File : '".$file."' not found. Please give valid file name");
			}
		}
		catch(WebException $e)
		{
			echo $e->getMessage();
		}
    }

	/**
	* [name] setJs
	* [type] method
	* [scope] public
	* [expl] use to set a javascript include
	* [expl] $this->setJs(<filename>);
	*/
    public function setJs($file)
    {
		try
		{
        if (file_exists($file))
        {
            $this->js .= '<script type="text/javascript" src="'.$file.'">'. "\n</script>\n";
            return TRUE;
        }
        else
        {
            throw new WebException("<b>Head class exception</b><br />JS file not found.</b><br> 
				   File : '".$file."' not found. Please give valid file name");
			}
		}
		catch(WebException $e)
		{
			echo $e->getMessage();
		}
    }

	/**
	* [name] setTitle
	* [type] method
	* [scope] public
	* [expl] use to set a page title
	* [expl] $this->setTitle('My webpage');
	*/
    function setTitle($data)
    {
        $this->title = "<title>$data</title>\n";
    }
    /**
	* [name] setText
	* [type] method
	* [scope] public
	* [expl] use to set text (css inline etc)
	* [expl] $this->setText('blablabla');
	*/
    function setText($data)
    {
        $this->text = $data;
    }


}

?>
