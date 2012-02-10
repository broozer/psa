<?php

/**
* [type] file
* [name] Th.php
* [package] Web
* [author] Wim Paulussen
*/

class Th extends Page
{
	
	private $_pointerTh = 0;
	private $_arTh;

	public function __construct()
	{
		try
		{
			if(!Page::$html_set || !Page::$head_set || !Page::$body_set )
			{
				throw new WebException("<b>Th class exception</b><br />Either &lt;html&gt; or &lt;head&gt; or &lt;body&gt; is not set.</b><br />
					All these tags need to be set in this order to generate valid html forms.");
			}
			if(!Table::$table_set)
			{
				throw new WebException("<b>Th class exception.</b><br />Table line (th) set without &lt;table&gt; set.<br />");
			}
		}
		catch(BaseException $e)
		{
			echo $e->getMessage();
		}
	}
	
	public function add($data='') {
		try
		{
			if ($data == '') {
				throw new BaseException("<b>Th class exception</b><br />AddElement without data.");
			}
			
			if (isset($this->_arTh))
			{
				$this->_pointerTh	= sizeof($this->_arTh);
			}
			$this->_arTh[$this->_pointerTh]['name'] 	= $data;
			if ($this->clas != '')
			{
				$this->_arTh[$this->_pointerTh]['class'] = $this->getClas();
			}
			return TRUE;
		}
		catch(BaseException $e)
		{
			echo $e->getMessage();
		}
	}
	
	public function build()
	{
		$this->html	= "<thead><tr>";
		for($i=0;$i<sizeof($this->_arTh);++$i)
		{
			$this->html	 .= "<th";
			if($this->id != '')
			{
				$this->html .= ' id="'.$this->getId().'" ';
				$this->setId('');
			}
			if(isset($this->_arTh[$i]['class']))
			{
				$this->html .= ' class="'.$this->_arTh[$i]['class'].'" ';
				$this->setClas('');
			}
			$this->html	 .= ">".$this->_arTh[$i]['name'].'</th>';
		}
		$this->html	 .= "</tr></thead>"."\r\n";
		$this->display();
	}

}
