<?php

if (isset ( $_POST ['submit'] ) && $_POST ['submit'] == 1) {
	
	for($offset_count = 1; $offset_count <= $_POST ['num_postvars']; $offset_count ++) {
		
		if (isset ( $_POST ['team_' . $offset_count] )) {
			$registration = new registration ( );
			
			try {
				$registration->new_registration ( $_POST ['team_' . $offset_count], $_SESSION ['tournament_id'], $_SESSION ['user'] );
				header ( "Location: /greifmasters/admin/tournament/$tournament->id/" );
			} catch ( Exception $exception ) {
				echo 'Error: ' . $exception->getMessage () . '<br />';
				echo 'File: ' . $exception->getFile () . '<br />';
				echo 'Line: ' . $exception->getLine () . '<br />';
			}
		}
	
	}

} else {
	
	echo '
	<form method="post" action="add_teams">
	<input type="hidden" name="submit" value="1" />
	';
	
	$query = "
			SELECT
				id, name
			FROM
				gm_teams
		";
	
	$result = mysql_query ( $query ) or die ( mysql_error () );
	
	$offset_count = 0;
	while ( $row = mysql_fetch_row ( $result ) ) {
		
		$is_registered = new registration ( );
		if ($is_registered->is_registered ( $row [0], $_SESSION ['tournament_id'] ) == FALSE) {
			
			$offset_count ++;
			echo '
					<input type="checkbox" name="team_' . $offset_count . '" value="' . $row [0] . '"/> ' . $row [1] . '<br />
				';
		
		}
	}
	echo '<input type="hidden" name="num_postvars" value="' . $offset_count . '"><input type="submit" value="Add teams" /></form>';
}
?>