<?php

function query_extension ($clause, $arguments, $where_clause_started=FALSE, $previous_arguments=FALSE){
	

	if (!is_array($arguments)){
		$arguments = array( $arguments );
	}
	
	switch ($clause) {
		
		case 'WHERE':
			
			$query_extension = '';
	
			if ($where_clause_started == FALSE){
				$query_extension .= 'WHERE ';
			}elseif ($previous_arguments == TRUE){
				$query_extension .= 'AND ';
			}
			
			foreach ($arguments as $value) {
				$query_extension .= $value . 'AND ';
			}
			
			$query_extension = rtrim($query_extension, 'AND ');

			
		return $query_extension;

		
	}
	

	
}

?>