<?php



if (isset ( $_GET ['p1'] ) && is_numeric ( htmlentities ( $_GET ['p1'] ) )) {
	$tournament_id = htmlentities ( $_GET ['p1'] );
	$_SESSION ['tournament_id'] = $tournament_id;
} elseif (isset ( $_SESSION ['tournament_id'] )) {
	$tournament_id = $_SESSION ['tournament_id'];
}




// load tournament -------------------------------------------------------




$tournament = new tournament ( );
$tournament->load_entry ( $tournament_id );



// actions ----------------------------------------------------------------
if ($tournament->get_status () == 0) {
	



	if (isset ( $_GET ['p2'] ) && $_GET ['p2'] == 'add_teams') {
		include 'inc/forms/add_teams.form.inc.php';
		return;
	}
	
	if (isset ( $_GET ['p2'] ) && $_GET ['p2'] == 'quick_add_team') {
		

		$_SESSION ['quick_add_team_to'] = $tournament_id;
		header ( "Location: " . BASE . "/teams/create" );
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
if (isset ( $_GET ['p2'] ) && $_GET ['p2'] == 'teams') {
	if (isset ( $_GET ['p3'] ) && $_GET ['p3'] == 'unregister') {
		$registration = new registration ( );
		$registration->delete ( $_GET ['p4'] );
	} elseif (isset ( $_GET ['p3'] ) && $_GET ['p3'] == 'details') {
		
		#@FIXME: output formatieren
		



		$team = new team ( );
		$team->load_entry ( $_GET ['p4'] );
		
		echo '<h2>Statistics: ' . $team->get_name () . '</h2>';
		echo '<h3>Goals</h3>';
		#@todo: goals, goals against (maybe in one table next to each other), goal difference in the last row
		



		$goals = $team->get_goals ( '', $_SESSION ['tournament_id'] );
		echo '<table class="border">
						<tr>
							<th>Match</th>
							<th>Opponent</th>
							<th>Player</th>
						</tr>
				';
		foreach ( $goals as $goal ) {
			echo '<tr><td><a href="' . BASE . '/play_tournament/matches/' . $goal ['match_id'] . '">' . $goal ['match_id'] . '</a></td><td>' . $goal ['opponent'] . '</td><td>' . $goal ['player_name'] . '</td></tr>' . "\n";
		}
		echo '<tr><th colspan="3">total: ' . sizeof ( $goals ) . '</th>';
		echo '</table><br />';
		
		echo '<h3>All matches</h3>';
		$matches = $team->get_matches ( '', $_SESSION ['tournament_id'] );
		echo '<table class="ranking">
						<tr>
							<th>Team 1</th>
							<th>Team 2</th>
							<th>Score</th>
							<th>Time</th>
							<th>Bracket</th>
						</tr>
				';
		foreach ( $matches as $match ) {
			echo '<td>';
			
			if ($match ['team1'] == $team->get_name ()) {
				echo '<b>' . $match ['team1'] . '</b>';
			} else {
				echo $match ['team1'];
			}
			
			echo '</td><td>';
			
			if ($match ['team2'] == $team->get_name ()) {
				echo '<b>' . $match ['team2'] . '</b>';
			} else {
				echo $match ['team2'];
			}
			
			echo '
						</td>
						<td>' . $match ['goals1'] . ':' . $match ['goals2'] . '</td>
						<td>' . $match ['time'] . '</td>
						<td>' . $match ['bracket_name'] . '</td>';
			echo '</tr>' . "\n";
		}
		echo '<tr><th colspan="5">total: ' . sizeof ( $matches ) . '</th>';
		echo '</table><br />';
		
		echo 'Playing in brackets: ';

		$brackets = $team->get_brackets ( $_SESSION ['tournament_id'] );
		
		foreach ( $brackets as $bracket ) {
			echo $bracket ['name'] . ', ' . "\n";
		}
		


		return;
	
	} else {
		include 'cont/inc/tables/registered_teams.table.inc.php';
		return;
	}

}

if (isset ( $_GET ['p2'] ) && $_GET ['p2'] == 'refs') {
	
	if (isset ( $_GET ['p3'] ) && $_GET ['p3'] != '') {
		if ($_GET ['p3'] == 'delete' && is_numeric ( ($_GET ['p4']) )) {
			
			$ref = new ref ( );
			$ref->load_entry ( $_GET ['p4'] );
			$ref->delete ();
		
		} elseif (isset ( $_POST ['submit'] )) {
			
			$name = $_POST ['name'];
			$court = $_POST ['court'];
			$pass = $_POST ['password'];
			$bracket = $_POST['bracket'];
			$passwords = password_generator ( $name, $pass );
			
			var_dump($passwords);


			if (isset ( $_POST ['update'] )) {
				$ref = new ref ( );
				$ref->load_entry ( $_POST ['update'] );
				if ($pass != ''){
					$ref->update ("salt='$passwords[0]', pass='$passwords[1]'", "id='" . $_POST ['update'] . "'" );
				}
				$ref->update ( "user='$name', court='$court', bracket='$bracket'", "id='" . $_POST ['update'] . "'" );
			
			} else {
				$ref = new ref ( );
				$ref->store ( $name, $court, $passwords );
			}
			

			header ( "Location: " . BASE . "/tournament/" . $_SESSION ['tournament_id'] . "/refs" );
			return;
		



		}
		
		echo '<form method="post" action="' . BASE . '/tournament/' . $_SESSION ['tournament_id'] . '/refs/submit">';
		
		if (is_numeric ( $_GET ['p3'] )) {
			
			$ref = new ref ( );
			$ref->load_entry ( $_GET ['p3'] );
			$name = $ref->get_name ();
			$court = $ref->get_court ();
			$bracket = $ref->get_bracket();
			$value = 'Save';
			
			echo '<input type="hidden" name="update" value="' . $_GET ['p3'] . '" />';
		} else {
			$name = '';
			$court = '';
			$bracket = '';
			$value = 'Add new ref';
		}
		
		$tournament = new tournament ( );
		$tournament->load_entry ( $_SESSION ['tournament_id'] );
		$courts = $tournament->get_courts ();
		$brackets = $tournament->get_brackets();
		
		?>

<table>
	<tr>
		<td>Name:</td>
		<td><input type="text" name="name" value="<?php
		echo $name;
		?>" /></td>
	</tr>
	<tr>
		<td>Court:</td>
		<td><select name="court">
					<?php
		foreach ( $courts as $row ) {
			echo '<option value="' . $row ['id'] . '"';
				if ($row['id'] == $court){echo ' selected';}
			echo ' >' . $row ['name'] . '</option>' . "\n";
		}
		
		?>
		</select></td>
	</tr>
	<tr>
		<td>Bracket:</td>
		<td><select name="bracket">
					<?php
		foreach ( $brackets as $row ) {
			echo '<option value="' . $row ['id'] . '"';
				if ($row['id'] == $bracket){echo ' selected';}
			echo ' >' . $row ['name'] . '</option>' . "\n";
		}
		
		?>
		</select></td>
	</tr>
	<tr>
		<td>Password:</td>
		<td><input type="password" name="password" /></td>
	</tr>
	<tr>
		<td colspan="2"><input type="submit" name="submit"
			value="<?php
		echo $value;
		?>" /></td>
	</tr>

</table>


</form>
<?php
		
		return;
	}
	




	// display info -------------------------------------------------------
	



	?>

<table class="border">
	<tr>
		<th>Name</th>
		<th>Court</th>
		<th>&nbsp;</th>
	</tr>
	
	
<?php
	
	$refs = new db ( 'users' );
	$refs = $refs->select ( 'id', "rights = 'ref'" );
	echo '<h3>Refs</h3><br /><a href="' . BASE . '/tournament/' . $_SESSION ['tournament_id'] . '/refs/add">add new ref</a>';
	
	foreach ( $refs as $ref ) {
		$temp = new ref ( );
		$temp->load_entry ( $ref ['id'] );
		$edit = BASE . '/tournament/' . $_SESSION ['tournament_id'] . '/refs/' . $ref ['id'];
		
		$court = new court ( );
		$court->load_entry ( $temp->get_court () );
		$court = $court->get_name ();
		echo '
		<tr>
			<td><a href="' . $edit . '">' . $temp->get_name () . '</a></td>
			<td>' . $court . '</td>
			<td><a href="' . BASE . '/tournament/' . $_SESSION ['tournament_id'] . '/refs/delete/' . $ref ['id'] . '"><img src="' . GFX_DELETE . '" /></a></td>
		</tr>
	';
	}
	
	echo '</table>
		';
	return;

}


if (isset ( $_GET ['p2'] ) && $_GET ['p2'] == 'status') {
	
	$new_status = $_GET ['p3'];
	$tournament->set_status ( $new_status );
}


if (isset ( $_GET ['p2'] ) && $_GET ['p2'] == 'clear_schedule') {
	
	$tournament->clear_schedule ();
	return;
}



if (isset ( $_GET ['p2'] ) && $_GET ['p2'] == 'reset') {
	#@todo: matches should be deleted, right? brackets too, then, status of tournament should be set accordingly, if not done so already
	


	$tournament->set_status ( 0 );
}

if (isset ( $_GET ['p2'] ) && $_GET ['p2'] == 'delete') {
	if (isset ( $_GET ['p3'] ) && $_GET ['p3'] == 'yes') {
		$tournament->delete ();
		#@todo: return value
	} else {
		echo '<a href="/greifmasters/admin/tournament/' . $tournament->get_id () . '/delete/yes">I am sure. Delete</a>';
	}
	return;
}


if (isset ( $_GET ['p2'] ) && $_GET ['p2'] == 'playing_times') {
	include 'inc/forms/playing_times.form.inc.php';
	return;
}


// display info -------------------------------------------------------



include 'cont/inc/tournament_outline.cont.inc.php';

include 'cont/inc/tournament_actions.cont.inc.php';



if ($tournament->get_status () < 1) {
	echo '<a href="/greifmasters/admin/tournament/' . $tournament->get_id () . '/add_teams">add existing teams</a><br />
		<a href="/greifmasters/admin/tournament/' . $tournament->get_id () . '/quick_add_team">quick create and add team</a>
		';
}

include 'cont/inc/tables/registered_teams.table.inc.php';



?>