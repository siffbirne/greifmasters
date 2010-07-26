<?php

$registered_teams = $tournament->get_registered_teams();

	
	echo'
		<table class="t1">
			<tr>
				<th>Name</th>
				<th>City</th>
				<th>Players</th>
				<th>actions</th>
			</tr>
	';
	
	#@todo: crap. should be done by some kind of table class
	if (mysql_affected_rows() == 0){
			echo end_table(3);
			return;
	}


	foreach ($registered_teams as $team){
		$new = new team();

		$new->load_entry($team['id']);
		$players = $new->get_players();
		
		#@todo: players names in there? not quite sure...
		echo'
				<tr>
					<td>'.$new->get_name().'</td>
					<td>'.$new->get_city().'</td>
					<td>'.$players['player1'].', '.$players['player2'].', '.$players['player3'].'</td>
					<td>action</td>
				</tr>
		';

		
	}
	

	echo'
		</table>	
	';


?>