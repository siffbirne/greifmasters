<?php

if (isset($_POST['submit']) && $_POST['submit']==1){
#@todo: das geht schöner:
	for ($i = 1; $i <= $_POST['num_postvars']; $i++) {

		if (isset($_POST['team_'.$i])){
			$registration = new registration();

				$registration->store($_POST['team_'.$i], $_SESSION['tournament_id'], $_SESSION['user']);
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


$i=0;
while ($row = mysql_fetch_row($result)){

	$is_registered = new registration();
	if ($is_registered->is_registered($row[0], $_SESSION['tournament_id'])==FALSE){

		$i++;
				echo'
					<input type="checkbox" name="team_'.$i.'" value="'.$row[0].'"/> '.$row[1].'<br />
				';

			}
	}
echo'<input type="hidden" name="num_postvars" value="'.$i.'"><input type="submit" value="Add teams" /></form>';
}
?>