<?php

/**
* [name] Web.php
* [type] file
* [package] Web
* [author] Wim Paulussen
* [since] 2007-11-27
* [update] 2009-07-31 : cleanup
*/

/**
* [name] Web
* [type] class
* [scope] abstract
*/

abstract class Web
{

    /** 
    * [type] attribute
    * [name] html
    * [scope] protected
    * [expl] holds string that holds the webpage
    * [expl] via ob_end_flush can be read
    */
    protected $html ='';
    
    /** 
    * [type] attribute
    * [name] output
    * [scope] private
    * [expl] determines where the data is written
    * [expl] if empty ->output to browser
    * [expl] if set -> output to file with that name
    */
    private $output;
    
    /** 
    * [type] attribute
    * [name] id
    * [scope] public
    * [expl] id attribute to tag
    */
    public $id = '';
    /** 
    * [type] attribute
    * [name] clas
    * [scope] public
    * [expl] clas attribute to tag
    */
    public $clas	= '';
    /** 
    * [type] attribute
    * [name] js
    * [scope] public
    * [expl] js attribute for putting javascript functions in place
    */
    public $js	= '';
    /** 
    * [type] attribute
    * [name] name
    * [scope] public
    * [expl] name (table,input...)
    */
    public $name;
	
    /**
    * [type] method
    * [name] display
    * [scope] public
    * [expl] display with an 'echo' the content of the html variable
    * [expl] 
    */
    public function display()
    {
	echo $this->html;
	$this->_clearHtml();
    }
    
    /**
    * [type] method
    * [name] dump
    * [scope] public
    * [expl] returns the data of the html variable
    * [expl] 
    */
    public function dump()
    {
            $this->_temp = $this->html;
            $this->_clearHtml();
            return $this->_temp;
    }

    /**
    * [type] method
    * [name] _clearHtml
    * [scope] protected
    * [expl] clears the html variable of content
    * [expl] 
    */
    protected function _clearHtml()
    {
            $this->html = '';
    }
    
    /**
    * [type] method
    * [name] build
    * [scope] public
    * [expl] returns the html output to the display function
    * [expl] ALL subclasses need to override this method
    */
    public function build()
    {
        if (isset($this->html))
        {
            $this->display();
            $this->_clearHtml();
        }
    }
    
    /**
    * [type] method
    * [name] setJs
    * [scope] public
    * [expl] set Js content
    */
    public function setJs($data) { $this->js = $data; }
    /**
    * [type] method
    * [name] setId
    * [scope] public
    * [expl] set Id
    */
    public function setId($data) { $this->id = $data; }
    /**
    * [type] method
    * [name] setClas
    * [scope] public
    * [expl] set class for element 
    */
    public function setClas($data) { $this->clas = $data; }
    /**
    * [type] method
    * [name] setName
    * [scope] public
    * [expl] sets name for element
    */
    function setName($data) { $this->name = $data; }
    /**
    * [type] method
    * [name] getJs
    * [scope] public
    * [expl] returns js value set
    */
    public function getJs() {return $this->js; }
    /**
    * [type] method
    * [name] getName
    * [scope] public
    * [expl] returns Name
    */
    public function getName() { return $this->name; }
    /**
    * [type] method
    * [name] getId
    * [scope] public
    * [expl] returns Id content
    */
    public function getId() { return $this->id; }
    /**
    * [type] method
    * [name] getClas
    * [scope] public
    * [expl] returns class content
    */
    public function getClas() { return $this->clas; }

}

?>