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
		include 'inc/forms/teams.form.inc.php';
		return;
	}
	


	// display info -------------------------------------------------------



	include 'cont/inc/tables/existing_teams.table.inc.php';
	
	


?>