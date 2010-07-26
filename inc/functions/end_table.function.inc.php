<?php

function end_table($columns, $code=''){
	
	switch ($code) {
		
		default:
			$message = 'no data found';
		break;
	}

	return '<tr><td colspan="'.$columns.'">'.$message.'</td></tr></table>';

	
}

?>