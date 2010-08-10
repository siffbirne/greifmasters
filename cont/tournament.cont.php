<?php



if (isset($_GET['p1']) && is_numeric(htmlentities($_GET['p1']))){
	$tournament_id = htmlentities($_GET['p1']);
	$_SESSION['tournament_id'] = $tournament_id;
}elseif(isset($_SESSION['tournament_id'])){
	$tournament_id = $_SESSION['tournament_id'];
}




	// load tournament -------------------------------------------------------

	$tournament = new tournament();
	$tournament->load_entry($tournament_id);



	// actions ----------------------------------------------------------------
	if ($tournament->get_status()==0){
		
		

		
		if( isset ($_GET ['p2']) && $_GET ['p2'] == 'add_teams') {
			include 'inc/forms/add_teams.form.inc.php';
			return;
		}
	
		if( isset ($_GET ['p2']) && $_GET ['p2'] == 'quick_add_team') {
			
			
			$_SESSION['quick_add_team_to'] = $tournament_id;
			header ( "Location: ".BASE."/teams/create");
			return;
			
			
			#return;
		}
	}
	
	
//	if ($tournament->get_status()>=1){
//		
//		if( isset ($_GET ['p2']) && $_GET ['p2'] == 'calculate_schedule') {
//			include 'cont/inc/calculate_schedule.cont.inc.php';
//			return;
//		}
//	}
	if( isset ($_GET ['p2']) && $_GET ['p2'] == 'teams') {
			if( isset ($_GET ['p3']) && $_GET ['p3'] == 'unregister') {
				$registration = new registration();
				$registration->delete($_GET ['p4']);
			}elseif( isset ($_GET ['p3']) && $_GET ['p3'] == 'details') {
				
				#@FIXME: output formatieren
				
				$team = new team();
				$team->load_entry($_GET ['p4']);
				
				echo 'stats for '.$team->get_name().'<br />';
				
				
				$goals = $team->get_goals('',$_SESSION['tournament_id']);
				echo '<table>
						<tr>
							<th>Opponent</th>
							<th>Player</th>
						</tr>
				';
				foreach ($goals as $goal){
					echo '<tr><td><a href="'.BASE.'/play_tournament/matches/'.$goal['match_id'].'">'.$goal['opponent'].'</a></td><td>'.$goal['player_name'].'</td></tr>'."\n";
				}
				echo '</table>';
				
				$matches = $team->get_matches('',$_SESSION['tournament_id']);
				echo '<table class="ranking">
						<tr>
							<th>Team 1</th>
							<th>Team 2</th>
							<th>Score</th>
							<th>Time</th>
						</tr>
				';
				foreach ($matches as $match){
					echo '<td>';
					
					if ($match ['team1'] == $team->get_name()) {
						echo '<b>' . $match ['team1'] . '</b>';
					} else {
						echo $match ['team1'];
					}
					
					echo '</td><td>';
					
					if ($match ['team2'] == $team->get_name()) {
						echo '<b>' . $match ['team2'] . '</b>';
					} else {
						echo $match ['team2'];
					}
					
					echo '
						</td>
						<td>' . $match ['goals1'] . ':' . $match ['goals2'] . '</td>
						<td>' . $match ['time'] . '</td>';
					echo'</tr>'."\n";
				}
				echo '</table>';
				
				
				$brackets = $team->get_brackets($_SESSION['tournament_id']);

				foreach ($brackets as $bracket){
					echo $bracket['name'].', '."\n";
				}

				
				
				return;
				
			}else{
				include 'cont/inc/tables/registered_teams.table.inc.php';
				return;
			}
			
		}
	
	if( isset ($_GET ['p2']) && $_GET ['p2'] == 'status') {
		
		$new_status = $_GET['p3'];
		$tournament->set_status($new_status);
	}
	
	
	if( isset ($_GET ['p2']) && $_GET ['p2'] == 'clear_schedule') {

		$tournament->clear_schedule();
		return;
	}



	if( isset ($_GET ['p2']) && $_GET ['p2'] == 'reset') {
		#@todo: matches should be deleted, right? brackets too, then, status of tournament should be set accordingly, if not done so already
		
		$tournament->set_status(0);
	}
	
	if( isset ($_GET ['p2']) && $_GET ['p2'] == 'delete') {
		if ( isset ($_GET ['p3']) && $_GET ['p3'] == 'yes') {
			$tournament->delete();
			#@todo: return value
		}else{
			echo '<a href="/greifmasters/admin/tournament/'.$tournament->get_id().'/delete/yes">I am sure. Delete</a>';
		}
		return;
	}
	
	
	if( isset ($_GET ['p2']) && $_GET ['p2'] == 'playing_times') {
		include 'inc/forms/playing_times.form.inc.php';
		return;
	}


	// display info -------------------------------------------------------

	include 'cont/inc/tournament_outline.cont.inc.php';

	include 'cont/inc/tournament_actions.cont.inc.php';



	if ($tournament->get_status()<1){
		echo '<a href="/greifmasters/admin/tournament/'.$tournament->get_id().'/add_teams">add existing teams</a><br />
		<a href="/greifmasters/admin/tournament/'.$tournament->get_id().'/quick_add_team">quick create and add team</a>
		';
	}

	include 'cont/inc/tables/registered_teams.table.inc.php';



?>