<?php



class time_dropdown_element extends dropdown_element{


	public function __construct($name, $hm, $select=''){
		
		$now = getdate();

		
			switch ($hm) {
				
				case 'h':
					$start = 0;
					$size = 24;
					$step = 1;
				break;	
				
				case 'm':
					$start = 0;
					$size = 60;
					$step = 15;
				break;

			}
	
		
			
			
		$elements = array();
		
			for ($i = $start; $i < $size; $i+=$step) {
				array_push($elements, sprintf ("%02d",$i));
			}

			
		parent::__construct($name, $elements, $select);
	
	}
	
	public function output(){
		return parent::output();
	}
	
}
?>