<?php

function table($columns, $contents, $name='', $class_id=''){
	
	if (!is_array($contents) || empty($contents)){return 'Invalid input for table';}
		
	$tableHead = '<table ';
	if ($class_id != ''){
		$tableHead .= $class_id.'="'.$name.'"';
	}
		
	$tableHead .= ">\n<tr>";

	foreach ($columns as $column){
		$tableHead .= '<th>'.$column.'</th>';
	}
	$tableHead .= "</tr>\n";
	
	#unset ($columns);
	
	if (empty($contents)){
		
		$message = 'no data found';
		#@todo: messages to seperate file. see other "todo"
		
		$tableContent = '<tr colspan="'.sizeof($columns).'">' . $message . "</tr>\n</table";
		return $tableHead.$tableContent;
		
	}
	
	$tableContent = '';

		foreach ($contents as $dataset){
			
			$tableContent .= '<tr>';
				
			foreach ($dataset as $value){
				$tableContent .= '<td>'.$value.'</td>'; 	
			}
			
			$tableContent .= "</tr>\n";
		
		}
		
	return $tableHead . $tableContent . "</table>\n";
	
	
}


?>