<?php

/**
* [name] Head.php
*/

class Head extends Base
{
    private $arMeta;
    private $pointerMeta = 0;
    private $charset = 'utf-8';
    private $css;
    private $text;
    public $js;
    private $title;
   
	function __construct()
	{
	    try
	    {
	        if(!Page::getHtml_set())
	        {
	            throw new PageException("<b>Head class exception</b><br>Html tag is not yet defined.</b><br> 
	            Please define &lt;html&gt; tag first.");
	        }
	    }
	    catch(PageException $e)
	    {
	        echo $e->getMessage();
	    }
	    Page::$head_set = TRUE;
	}
	
	
    public function build()
    {
        try
        {
            $this->html .="
            <head>
            <meta http-equiv=\"Refresh\" content=\"300\">";

            if (isset($this->charset))
            {
                $this->html     .= "<meta charset=\"".$this->charset."\">\n";
            }
            else
            {
                throw new PageException("<b>Head class exception</b><br>Charset not set.</b><br> 
                Usage \$&lt;objectname&gt;->setCharset(\"&lt;charset - name&gt;\")");
            }

            if (isset($this->arMeta))
            {
                for ($i=0;$i<sizeof($this->arMeta);++$i)
                {
                    $this->html     .= '<meta name="'.$this->arMeta[$i]['name'].'" content="'.$this->arMeta[$i]['content'].'">'."\n";
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

            if (isset($this->css)) {
                $this->html     .= $this->css;
            }

            if (isset($this->js)) {
                $this->html     .= $this->js;
            }

            if ($this->text !== '') {
				$this->html .= $this->text;
			}

            $this->html .= "</head>\n";
            $this->display();
        }
        catch(PageException $e)
        {
            echo $e->getMessage();
        }
    }

   
    public function setMeta($name='',$content='')
    {
		try
		{
			if ($name == '' || $content == '')
			{
				throw new PageException("<b>Head class exception</b><br /> 'name' or 'content' not set in setMeta.</b><br> 
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
		catch(PageException $e)
		{
			echo $e->getMessage();
		}
		
	}

	public function setCharset($data='')
    {
		try
		{
			if ($data == '')
			{
	
				throw new PageException("<b>Head class exception</b><br />Charset cannot be blank.</b><br> 
				   Choose a relevant charset.");
			}
			$this->charset = $data;
		}
		catch(PageException $e)
		{
			echo $e->getMessage();
		}
    }
	
    public function setCss($file,$media="all")
    {
		try
		{
			if (file_exists($file))
			{
				$this->css .= '<link href="'.$file.'" rel="stylesheet" ';
	
				if($media != "all")
				{
					$this->css .= ' media="'.$media.'" ';
				}
	
				$this->css .= '>'."\n";
				return TRUE;
			}
			else
			{
			   throw new PageException("<b>Head class exception</b><br />CSS file not found.</b><br> 
				   File : '".$file."' not found. Please give valid file name");
			}
		}
		catch(PageException $e) {
			echo $e->getMessage();
		}
    }

	
    public function setJs($file) {
		try {
	        if (file_exists($file))
	        {
	            $this->js .= '<script src="'.$file.'">'. "\n</script>\n";
	            return TRUE;
	        }
	        else
	        {
            	throw new PageException("<b>Head class exception</b><br />JS file not found.</b><br> 
				   File : '".$file."' not found. Please give valid file name");
			}
		}
		catch(PageException $e)
		{
			echo $e->getMessage();
		}
    }

    function setTitle($data) {
        $this->title = "<title>$data</title>\n";
    }

    /**
	* [name] setText
	* [type] method
	* [scope] public
	* [expl] use to set text (css inline etc)
	* [expl] $this->setText('blablabla');
	*/
    function setText($data) {
        $this->text = $data;
    }

}

?>
