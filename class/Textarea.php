<?php


class Textarea extends Body
{
	private $values = '';
	private $rows	= '60';
	private $cols = '3';
	private $readonly = FALSE;

	function setValue($data) { $this->values = $data; }
	function setRows($data) { $this->rows = $data; }
	function setCols($data) { $this->cols = $data; }
	function setReadonly() { $this->readonly = TRUE; }

	function build()
	{

		$this->html	 = '<textarea name="';
		$this->html	.= $this->getName();
		$this->html	.= '" rows="';
		$this->html	.=$this->rows;
		$this->html	.='" cols="';
		$this->html	.=$this->cols;
		$this->html	.= '"';

		if ($this->readonly)
		{
			$this->html .= " readonly ";

		}

		if ($this->id != '')
		{
			$this->html .= ' id="'.$this->getId().'"';

		}

		$this->html	.= '>'.$this->values.'</textarea>';

		return $this->html;
	}

}



?>

