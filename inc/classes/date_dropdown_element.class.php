<?php



class date_dropdown_element extends dropdown_element{


	public function __construct($name, $dmy, $select=''){
		
		$now = getdate();

		
			switch ($dmy) {
				
				case 'wday':
					$start = 1;
					$size = 31;
				break;	
				
				case 'mon':
					$start = 1;
					$size = 12;
				break;
				
				case 'year':
					$start = $now['year'];
					$size = $now['year']+2;
				break;
			}
	
		
			
			
		$elements = array();
		
			for ($i = $start; $i <= $size; $i++) {
				array_push($elements,$i);
			}

			
			
		parent::__construct($name, $elements, $select);
	
	}
	
	public function output(){
		return parent::output();
	}
	
}
?>