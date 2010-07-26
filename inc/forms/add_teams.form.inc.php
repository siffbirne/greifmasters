<?php

if (isset($_POST['submit']) && $_POST['submit']==1){
#@todo: das geht schöner:
	for ($offset_count = 1; $offset_count <= $_POST['num_postvars']; $offset_count++) {

		if (isset($_POST['team_'.$offset_count])){
			$registration = new registration();

				$registration->store($_POST['team_'.$offset_count], $_SESSION['tournament_id'], $_SESSION['user']);
				header ( "Location: ".BASE."/tournament/".$_SESSION['tournament_id']."/" );

		}

	}


}else{

echo '
	<form method="post" action="'.BASE.'/tournament/'.$tournament_id.'/add_teams">
	<input type="hidden" name="submit" value="1" />
	';

#@todo: swap database operation for something using the corresponding classes. more important: query does not belong in the form file

$query = "
			SELECT
				id, name
			FROM
				teams
		";

		$result = mysql_query ( $query ) or die ( mysql_error () );


$offset_count=0;
while ($row = mysql_fetch_row($result)){

	$is_registered = new registration();
	if ($is_registered->is_registered($row[0], $_SESSION['tournament_id'])==FALSE){

		$offset_count++;
				echo'
					<input type="checkbox" name="team_'.$offset_count.'" value="'.$row[0].'"/> '.$row[1].'<br />
				';

			}
	}
echo'<input type="hidden" name="num_postvars" value="'.$offset_count.'"><input type="submit" value="Add teams" /></form>';
}
?>