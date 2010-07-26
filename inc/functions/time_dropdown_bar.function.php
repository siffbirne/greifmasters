<?php




function time_dropdown_bar($name){


	$hours = new time_dropdown_element($name.'_select_hours', 'h');
	$minutes = new time_dropdown_element($name.'_select_minutes', 'm');
	
	
	echo $hours->output().':'.$minutes->output();
	
}

?>