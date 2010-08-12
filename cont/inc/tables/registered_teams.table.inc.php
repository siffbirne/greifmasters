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



	foreach ($registered_teams as $ref){
		$new = new team();

		$new->load_entry($ref['id']);
		$players = $new->get_players();
		
		#@todo: players names in there? not quite sure...
		echo'
				<tr>
					<td>'.$new->get_name().'</td>
					<td>'.$new->get_city().'</td>
					<td>'.$players['player1'].', '.$players['player2'].', '.$players['player3'].'</td>
					<td>
					<a href="'.BASE.'/tournament/'.$_SESSION['tournament_id'].'/teams/unregister/'.$ref['reg_id'].'">
					<img src="'.GFX_DELETE.'" alt="delete registration" /></a>
					&nbsp;<a href="'.BASE.'/tournament/'.$_SESSION['tournament_id'].'/teams/details/'.$ref['id'].'">
					<img src="'.GFX_VIEW.'" alt="details" />
					</a>
					</td>
				</tr>
		';

		
	}
	

	echo'
		</table>	
	';


?>