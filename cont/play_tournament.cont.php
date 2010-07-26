<?php

if (isset($_GET['p1']) && is_numeric(htmlentities($_GET['p1']))){
	$tournament_id = htmlentities($_GET['p1']);
	$_SESSION['tournament_id'] = $tournament_id;
	unset ($_SESSION['match_id'], $_SESSION['bracket_id']);
}elseif(isset($_SESSION['tournament_id'])){
	$tournament_id = $_SESSION['tournament_id'];
}else{
	$_SESSION['notification']=2;
	header ( "Location: /admin" );
	break;
}



	$tournament = new tournament();
	$tournament->load_entry($tournament_id);


// actions ----------------------------------------------------------------

//	if( isset ($_GET ['action']) && $_GET ['action'] == 'add_team') {
//		include ('cont/inc/add_team.cont.inc.php');
//	}
//
//
//
//
//	if( isset ($_GET ['action']) && $_GET ['action'] == 'status') {
//		$new_status = $_GET['value'];
//		include ('cont/inc/change_status.cont.inc.php');
//	}
//
//
//
//	if( isset ($_GET ['action']) && $_GET ['action'] == 'reset') {
//		//delete all matches?
//		$new_status = 1;
//		include ('cont/inc/change_status.cont.inc.php');
//	}

	
	
	if (isset($_GET['p1']) && $_GET['p1']=='matches'){
			
		include 'cont/playtournament/matches.playtournament.cont.inc.php';
		
		
		
	}
	
	if (isset($_GET['p1']) && $_GET['p1']=='brackets'){
			
		include 'cont/playtournament/brackets.playtournament.cont.inc.php';
		
		
		
	}
	


?>