<?php




function date_dropdown_bar($name){


	$days = new date_dropdown_element($name.'_select_day', 'wday');
	$months = new date_dropdown_element($name.'_select_month', 'mon');
	$years = new date_dropdown_element($name.'_select_year', 'year');
	
	
	echo $days->output().'.'.$months->output().'.'.$years->output();
	
}

?>