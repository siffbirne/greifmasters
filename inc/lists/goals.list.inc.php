<?php
if ($goals != FALSE){
	foreach ($goals as $goal){
			echo $goal['player']." ('".$goal['g_minute'];
			if ($goal['regular'] == 0){
				echo ', own goal';
			}
			echo ') <a class="delete_goal change_goal" href="'.BASE.'/play_tournament/matches/ong/goal/delete/'.$goal['id'].'">delete</a><br />';
	}
}
?>
