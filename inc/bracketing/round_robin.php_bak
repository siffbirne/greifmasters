<?php
$bracket_type = 'Round Robin';
$steps = 4;



if (isset($_SESSION['temp']['bracket'])){

if (isset($_SESSION['temp']['bracket']['nextstep'])){

	switch ($_SESSION['temp']['bracket']['nextstep']){
		
		
		
		case 1:
			
			if (is_numeric($_POST['numberofgroups'])){
				$_SESSION['temp']['bracket']['numberofgroups'] = $_POST['numberofgroups'];
				$numberofgroups = $_SESSION['temp']['bracket']['numberofgroups'];
			}else{
				die('please enter a number');
			}
			
			switch ($_POST['assignment']){
				case 'manually':
					
				break;
				
				case 'randomly':
					$tournament = new tournament();
					$tournament->load_entry($_SESSION['tournament_id']);
					$registered_teams = $tournament->get_registered_teams();
					
					if ($registered_teams % $numberofgroups != 0){
						echo 'Warning: Number of teams not divisible by number of groups. If you proceed, there will be at least one group containing a different amount of teams than the other groups.<br />';
					}
					
					$letters = array();
					foreach(range('a', 'z') as $letter) {
					    $letters[] = $letter;
					}
					
					$groups = array();
					for ($offset_count=0; $offset_count<$numberofgroups; $offset_count++){
						$groups[] = $letters[$offset_count];
					}
					shuffle($registered_teams);
					
					$offset_count=0;
					foreach ($registered_teams as $team){
						if ($offset_count >= sizeof($groups)){$offset_count=0;}
						$instanz = new registration();
						$instanz->load_entry($team['reg_id']);
						$instanz->set_group_assignment($groups[$offset_count]);
						$offset_count++;
					}
					
					$bracket = new bracket();
					
					
					$bracket->get_teams_in_bracket();
					
					
					
				break;
			}
			

		
		case 2:
			
			
			

//			
//			$bracket->seeding_step1();

			include 'inc/forms/new_bracket_step2_kasys_temp.form.inc.php';
			
//			if (isset($_SESSION['test']['seeding'])){
//				include 'inc/forms/new_bracket_step2_2.form.inc.php';
//			}else{
//				
//				include 'inc/forms/new_bracket_step2_1.form.inc.php';
//			}

		break;
		
		case 3:
			
			$_SESSION['temp']['bracket']['offset'] = $_POST['offset'];

			include 'inc/forms/new_bracket_step3.form.inc.php';
		break;
		
		case 4:
			
			
			$bracket->load_entry($_SESSION['temp']['bracket']['bracket_id']);
			$bracket->set_timelimit1($_POST['timelimit1']);
			$bracket->set_pause1($_POST['pause1']);
			
			
			$bracket->draw_bracket($_SESSION['temp']['bracket']['bracket_id'], $_SESSION['temp']['bracket']['offset'],TRUE);
			$bracket->set_status(4);
			
			unset ($_SESSION['temp']['bracket']);
			
			
		break;
	}

}else{
	
	$_SESSION['temp'] = array();
	$_SESSION['temp']['bracket'] = array();
	$_SESSION['temp']['bracket'];
	$_SESSION['temp']['bracket']['type'] = 'round_robin';
	$_SESSION['temp']['bracket']['nextstep'] = 1;
	
	echo '
		<form name="bracketing" method="post" action="' . BASE . '/play_tournament/brackets/new/">
		Number of groups: <input type="text" name="numberofgroups" maxlength="2" /><br />
		Assignment of teams: <select name="assignment">
			<option>randomly</option>
			<option>manually</option>
		</select></br>
		<input type="submit" value="proceed" />
		</form>
	';
	
	
	
}
}
?>