<?php
if ($goals != FALSE){
	foreach ($goals as $goal){
		
			if ($goal['player_id'] == 0){
				$player = 'general';
			}else{
				$player = $goal['player'];
			}
			echo $player." ('".$goal['g_minute'];
			if ($goal['regular'] == 0){
				echo ', own goal';
			}
			echo ') <a class="delete_goal change_goal" href="'.BASE.'/play_tournament/matches/ong/'.$_SESSION['court_id'].'/goal/delete/'.$goal['id'].'">delete</a><br />';
	}
}
?>
