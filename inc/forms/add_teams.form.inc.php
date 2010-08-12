<?php

if (isset($_POST['submit']) && $_POST['submit']==1){
#@todo: das geht schöner:
	for ($offset_count = 1; $offset_count <= $_POST['num_postvars']; $offset_count++) {

		if (isset($_POST['team_'.$offset_count])){
			$registration = new registration();

				$registration->store($_POST['team_'.$offset_count], $_SESSION['tournament_id'], $_SESSION['user']);
				

		}

	}
	header ( "Location: ".BASE."/tournament/".$_SESSION['tournament_id']."/" );


}else{

echo '
	<form method="post" action="'.BASE.'/tournament/'.$tournament_id.'/add_teams">
	<input type="hidden" name="submit" value="1" />
	';

#@todo: check registered teams


$refs = new team();
$refs = $refs->list_entries();

$offset_count = 0;
	foreach ($refs as $row){
		$offset_count++;
				echo'
					<input type="checkbox" name="team_'.$offset_count.'" value="'.$row['id'].'"/> '.$row['name'].'<br />
				';
			}

echo'<input type="hidden" name="num_postvars" value="'.$offset_count.'"><input type="submit" value="Add teams" /></form>';
}
?>