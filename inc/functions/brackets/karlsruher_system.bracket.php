<?php

function karlsruher_system($tournament_id){
	
	$start_time='2010-02-05 10:00:00';
	$match_duration = 8;
	$pause = 2;
	

	
	// paarungen zusammenstellen..............................................................
	
	$offset=3;

	$tournament = new tournament();
	$tournament->load_tournament($tournament_id);
	$registered_teams = $tournament->get_registered_teams();
	
	$matchlist = array();
	$number_of_teams = sizeof($registered_teams);
	
	
	$numbers = array();
		for ($i=0;$i<$number_of_teams; $i++){
			$numbers[] = $i;
		}
	
	
	foreach ($numbers as $team){
		for ($i=1; $i<=$offset; $i++){
			
			
			$opponent = $team+$i;
			if ($opponent<$number_of_teams){
				$matchlist[]=array($registered_teams[$team], $registered_teams[$opponent]);
				echo $registered_teams[$team]."-". $registered_teams[$opponent]."<br>";
			}
			
			if($team - $i < 0){
				$opponent = $team + $number_of_teams - $i;
				$matchlist[]=array($registered_teams[$team], $registered_teams[$opponent]);
				echo $registered_teams[$team]."-". $registered_teams[$opponent]."<br>";
			}
		}
	}
	//......................................................................................
	
	$time=strtotime($start_time);
$datetime=date("Y:m:d H:i:s", $time);
	
	
	

// matches in upc matches...................................................................
	foreach($matchlist as $match){
		
		$query="
			INSERT INTO 
				upc_matches (bracket_id, team1, team2)
			VALUES
				('".$_SESSION['bracket_id']."', '$match[0]', '$match[1]')
		";

		
		mysql_query ( $query ) or die ( mysql_error () );
		$time += ($match_duration+$pause)*60;
	}

}


?>