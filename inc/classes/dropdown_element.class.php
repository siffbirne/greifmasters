<?php

class dropdown_element{
	
	private $elements = array();
	private $output;
	private $selected;
	private $name;
	
	public function __construct($name, $elements, $select=''){

		$this->name = $name;
		$this->elements = $elements;
		$this->select = $select;

	}

	
	public function output(){
		
		$output = '<select name="'.$this->name.'">'."\n";
		
			foreach($this->elements as $value){
				
				$output .= '<option ';
					if ($this->select == $value){
						$output .= 'selected';
					}
				$output .= ">$value</option>\n";
				
			}
		
		$output .= "</select>\n";
		return $output;
	}
}




?>