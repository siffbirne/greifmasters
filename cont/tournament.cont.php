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
				
				$team = new team();
				$team->load_entry($_GET ['p4']);
				
				var_dump($team->get_goals());
				var_dump($team->get_matches());
				var_dump($team->get_brackets());
				
				
				
				
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