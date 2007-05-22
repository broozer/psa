<?php

/*
** [type] file
** [name] Head.php
** [author] Wim Paulussen
** [since] 2006-12-19
** [update] 2007-01-16
** [todo] testing
** [todo] 
** [end]
*/

/*
** [class] Head
** [extend] Html
*/
class Head extends Html
{
	/* 
	** [type] attribute
	** [name] arMeta
	** [scope] private
	** [expl] array for holding meta-data info
	** [end]
	*/
    private $arMeta;
	/* 
	** [type] attribute
	** [name] pointerMeta
	** [scope] private
	** [expl] keeps size of arMeta array
	** [end]
	*/
    private $pointerMeta = 0;
	/* 
	** [type] attribute
	** [name] css
	** [scope] private
	** [expl] variable containg name of css file to include
	** [end]
	*/
    private $css;
	/* 
	** [type] attribute
	** [name] js
	** [scope] private
	** [expl] variable for inclusion of javasript files
	** [end]
	*/
    private $js;
	/* 
	** [type] attribute
	** [name] title
	** [scope] private
	** [expl] variable for title field - defaults to 'no title'
	** [end]
	*/
    private $title;

	/*
	** [type] method
	** [name] __construct
	** [scope] public (inherited)
	** [expl] displays Head tag and some 'compulsory' meta-tags
	** [end]
	*/
    function __construct()
    {
        $this->html .='
<head>
<meta http-equiv="Pragma" content="no-cache" />
<meta http-equiv="content-type" content="text/html; charset=UTF-8" />
<meta name="author" content="Wim Paulussen" />
<meta name="engine" content="Web - asgc 2006 - version 2" />'."\n";
        // $this->display();
    }
	
	/*
	** [type] method
	** [name] build
	** [scope] public
	** [expl] after all tags are set , you run this function
	** [end]
	*/
    public function build()
    {
        $this->html .= '';

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

        if (isset($this->loose))
        {
            $this->html     .= $this->loose;
        }

        $this->html .= "</head>\n";
       	$this->display();
    }

    /*
	** [type] method
	** [name] setMeta
	** [scope] public
	** [expl] use to fill meta-array
	** [expl] $this->setMeta('name',<your name>);
	** [end]
	*/
    public function setMeta($name='',$content='')
    {
        if ($name == '' || $content == '')
        {
            $this->setS('s_error',"'name' or 'content' NOT set in setMeta.");
            return FALSE;
        }

        if (isset($this->arMeta))
        {
            $this->pointerMeta    = sizeof($this->arMeta);
        }
        $this->arMeta[$this->pointerMeta]['name']    = $name;
        $this->arMeta[$this->pointerMeta]['content']    = $content;
        return TRUE;
    }

	/*
	** [type] method
	** [name] setCss
	** [scope] public
	** [expl] use to set a css file
	** [expl] $this->setCss(<filename>);
	** [end]
	*/
    public function setCss($file)
    {
        if (file_exists($file))
        {
            $this->css = '<link href="'.$file.'" rel="stylesheet" type="text/css" />'."\n";
            return TRUE;
        }
        else
        {
            $this->setS('s_error','File CSS does not exist');
            return FALSE;
        }
    }

	/*
	** [type] method
	** [name] setJs
	** [scope] public
	** [expl] use to set a javascript include
	** [expl] $this->setJs(<filename>);
	** [end]
	*/
    public function setJs($file)
    {
        if (file_exists($file))
        {
            $this->js .= '<script type="text/javascript" src="'.$file.'">'. "\n</script>\n";
            return TRUE;
        }
        else
        {
            $this->SetS('s_error','File Javascript does not exist');
            return FALSE;
        }
    }

	/*
	** [type] method
	** [name] setTitle
	** [scope] public
	** [expl] use to set a page title
	** [expl] $this->setTitle('My webpage');
	** [end]
	*/
    function setTitle($data)
    {
        $this->title = "<title>$data</title>\n";
    }

	/*
	** [type] method
	** [name] __destruct
	** [scope] public (inherited)
	** [expl] ? error mgmt ??
	** [end]
	*/
	function __destruct()
	{
		//void
	}

}

?>
