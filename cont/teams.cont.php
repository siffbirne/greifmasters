<?php
//if (isset($_GET['team_id']) && is_numeric(htmlentities($_GET['team_id']))){
//	$team_id = htmlentities($_GET['team_id']);
//	$_SESSION['team_id'] = $team_id;
//}elseif(isset($_SESSION['team_id'])){
//	$team_id = $_SESSION['team_id'];
//}
//else{
//	$_SESSION['notification']=2;
//	header ( "Location: /greifmasters/admin/tournament/$tournament->id/" );
//	break;
//}


	// actions ----------------------------------------------------------------

	if( isset ($_GET ['p1']) &&  $_GET ['p1'] != '') {
		
		if (isset ( $_POST ['submit'] )) {
				
			$team_name = $_POST['team_name'];
			$city = $_POST['city'];
			$player1 = $_POST['player1'];
			$player2 = $_POST['player2'];
			$player3 = $_POST['player3'];	
			
			
			
			
			if (isset($_POST['update'])){
				$team = new team();
				$team->load_entry($_POST['update']);
				#@todo: players should be handled separetly at some point. you should not be able to change the name, but to choose another player who already exists in the database
				$team->update("name='$team_name', city='$city'", "id='".$_POST['update']."'");
				
				$players = $team->get_players();
				for ($i=1; $i<=3; $i++){
					$entry = new player();
					$entry->load_entry($players['player'.$i.'_id']);
					$entry->set_name($_POST['player'.$i]);
				}
				
			}else{
				$team = new team();
				$team->store($team_name, $city, $player1, $player2, $player3);
				
			}
				
			if (isset ($_SESSION['quick_add_team_to'])){
				#@todo: seems to be a stupid way. how to add teams? 
				$registration = new registration ();
				$registration->store($team->get_id(), $_SESSION['quick_add_team_to']);
				header ( "Location: ".BASE."/tournament/" . $_SESSION['quick_add_team_to']);
				unset($_SESSION['quick_add_team_to']);
				
			}else{
					header ( "Location: ".BASE."/teams");
			}
			
					
				
		} else {
			
			echo '<form method="post" action="'.BASE.'/teams/submit">';
			
			if( isset ($_GET ['p1']) && is_numeric($_GET ['p1'])) {
				
				$team = new team();
				$team->load_entry($_GET ['p1']);
				$team_name = $team->get_name();
				$city = $team->get_city();
				$players = $team->get_players();
				$value = 'Save';
				
				echo '<input type="hidden" name="update" value="'.$_GET ['p1'].'" />';
			}else{
				$team_name = '';
				$city = '';
				$players = array();
				$value = 'Create new team';
			}
					
			?>
				
			<table>
				<tr>
					<td>Team name:</td>
					<td><input type="text" name="team_name" value="<?php echo $team_name; ?>" /></td>
				</tr>
				<tr>
					<td>City:</td>
					<td><input type="text" name="city" value="<?php echo $city; ?>" /></td>
				</tr>
				<tr>
					<td>Player 1:</td>
					<td><input type="text" name="player1" value="<?php echo $players['player1']; ?>" /></td>
				</tr>
				<tr>
					<td>Player 2:</td>
					<td><input type="text" name="player2" value="<?php echo $players['player2']; ?>" /></td>
				</tr>
				<tr>
					<td>Player 3:</td>
					<td><input type="text" name="player3" value="<?php echo $players['player3']; ?>" /></td>
				</tr>
				<tr>
					<td colspan="2"><input type="submit" name="submit" value="<?php echo $value; ?>" /></td>
				</tr>
			
			</table>
			
			
			</form>
			<?php
		
		return;
		}
		return;
	}
	


	// display info -------------------------------------------------------

?>

	<table class="border">
	<tr>
		<th>Name</th>
		<th>City</th>
		<th>Players</th>
	</tr>
	
	
<?php

$teams = new db('teams');
$teams = $teams->select('id');

foreach ($teams as $team){
	$temp = new team();
	$temp->load_entry($team['id']);
	$players = $temp->get_players();
	$edit = BASE.'/teams/'.$team['id'];
	echo'
		<tr>
			<td><a href="'.$edit.'">'.$temp->get_name().'</a></td>
			<td>'.$temp->get_city().'</td>
			<td>'.$players['player1'].', '.$players['player2'].', '.$players['player3'].'</td>
		</tr>
	';
}

echo '</table>
		';
	
	
	


?>