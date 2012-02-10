<?php

/**
* [name] Base.php
* [author] Wim Paulussen
* [since] 2011.05.28
*/

abstract class Base
{
    protected $html ='';
    
    /** 
    *  determines where the data is written
    *  if empty ->output to browser
    *  if set -> output to file with that name
    */
    public static $output;
    public static $outputFile = '';

    public $id = '';
    public $clas = '';
    public $js	= '';
    public $name;
	
    /**
    *  display with an 'echo' the content of the html variable
    */
    public function display()
    {
    		/**/
    		self::$output = self::$output.$this->html;
		    $this->_clearHtml();
    }
    
    public function dump()
    {
            self::$output = self::$output.$this->html;
            $this->_clearHtml();
    }

    protected function _clearHtml()
    {
            $this->html = '';
    }
    
    public function build()
    {
        if (isset($this->html))
        {
            $this->display();
            $this->_clearHtml();
        }
    }
    
    public function setJs($data) { $this->js = $data; }
    public function setId($data) { $this->id = $data; }
    public function setClas($data) { $this->clas = $data; }
    public function setName($data) { $this->name = $data; }
    
    public function getJs() {return $this->js; }
    public function getName() { return $this->name; }
    public function getId() { return $this->id; }
    public function getClas() { return $this->clas; }

}

?>
