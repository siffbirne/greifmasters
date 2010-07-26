<?php



if (isset ( $_GET ['p2'] ) && $_GET ['p2'] == 'ong') {
	include 'cont/playtournament/upnow.playtournament.cont.inc.php';
	return;
	
}







if (isset ( $_GET ['p2'] ) && is_numeric( $_GET ['p2'])) {
	
	if (isset( $_GET ['p3'] ) && $_GET ['p3'] == 'reschedule'){
		
		$match = new match();
		$match->load_entry($_GET ['p2']);
		$match->reschedule();
		
		header("Location: ".BASE."/play_tournament/matches/ong");
		return;
		
	}
	
	$match = new match();
	$match->load_entry($_GET['p2']);
	
	$team1 = new team();
	$team1->load_entry($match->get_team1());
	$team2 = new team();
	$team2->load_entry($match->get_team2());
	
	$goals1 = $match->get_goals_1();
	$goals2 = $match->get_goals_2();
	
	
	echo '
		this is quite temporary...<table widht="300px">
			<tr>
				<td>'.$team1->get_name().'</td>
				<td>&nbsp;</td>
				<td>'.$team2->get_name().'</td>
			</tr>
			<tr>
				<td>
	';
	
	echo $goals1['count'] . ' (';
	foreach ($goals1['goals'] as $goal){
		echo $goal['player'].', ';
	}
	echo'
					)
				</td>
				<td>:</td>
				<td>
	';
	
	echo $goals2['count'] . ' (';
	foreach ($goals2['goals'] as $goal){
		echo $goal['player'].', ';
	}
	echo'
					)</td>
			</tr>
		</table><br />
	';
	
	switch ($match->get_status()){
		case 0:
			echo 'match is scheduled';
		break;
		
		case 1:
			echo '<a href="'.BASE.'/play_tournament/matches/'.$match->get_id().'/reschedule">set back to "not finished" (match will be scheduled again; use this to modify results)</a>';
		break;
	}
	
	return;
	
}elseif (isset ( $_GET ['p2'] ) && $_GET ['p2'] == 'fin') {
	
	?>

<table class="ranking">
	<tr>
<!--		<th>Court</th>-->
		<th>Team 1</th>
		<th>Team 2</th>
		<th>Score</th>
		<th>Time</th>
		<th>Action</th>
	</tr>
	
	
<?php
	
	$query = "
		SELECT
			t1.name AS team1,
			t2.name AS team2,
			t1.id AS team1_id,
			t2.id AS team2_id,
			DATE_FORMAT(m.datetime, '%a, %H:%i') AS time,
			m.id AS match_id,
			(
				SELECT
					count(*)
				FROM
					goals
				WHERE
					((team_id = t1.id AND regular = '1')
					OR
					(team_id != t1.id AND regular = '0'))
				AND
					match_id = m.id
			) AS goals1,
			(
				SELECT
					count(*)
				FROM
					goals
				WHERE
					((team_id = t2.id AND regular = '1')
					OR
					(team_id != t2.id AND regular = '0'))
				AND
					match_id = m.id
			) AS goals2
		FROM
			matches AS m
			INNER JOIN teams AS t1 ON t1.id = m.team1
			INNER JOIN teams AS t2 ON t2.id = m.team2
		WHERE m.status = 1
		AND m.bracket_id = '".$_SESSION['bracket_id']."'
		ORDER BY datetime DESC
		
	";
	

	$matches = new match ( );
	$matches = $matches->fetch_results ( $query );
	
	foreach ( $matches as $match ) {
		
		echo '
		<tr>

			<td>';
		
			if ($match ['goals1'] > $match ['goals2']) {
				echo '<b>' . $match ['team1'] . '</b>';
			} else {
				echo $match ['team1'];
			}
			 
			echo '</td><td>';
			
			if ($match ['goals2'] > $match ['goals1']) {
				echo '<b>' . $match ['team2'] . '</b>';
			} else {
				echo $match ['team2'];
			}
			
			echo '
			</td>
			<td>' . $match ['goals1'] . ':' . $match ['goals2'] . '</td>
			<td>' . $match ['time'] . '</td>
			<td><a href="'.BASE.'/play_tournament/matches/'.$match['match_id'].'"><img src="'.GFX_EDIT.'" /></a></td>
		</tr>
		';
	
	}
	
	?>

</table>
<?php

} elseif (isset ( $_GET ['p2'] ) && $_GET ['p2'] == 'upc') {
	
	if (isset ($_GET['p3']) && $_GET['p3'] == 'rearrange'){
		
		
		$tournament = new tournament();
		$tournament->load_entry($_SESSION['tournament_id']);
		$playing_times = $tournament->get_playing_times();
	
		
		foreach ($playing_times as $index => $timespan){
			if (time() < strtotime($timespan['end']) && time() > strtotime($timespan['begin'])){
				$start = time();
				$current_playing_time_index = $index;
			}elseif(!isset ($start)){
				$start = strtotime($timespan['begin']);
				$current_playing_time_index = $index;
			}
	
		}
		
		if ($playing_times == FALSE){echo 'No playing times set. Please do so before scheduling.'; return;}
		
		$lower_limit = 7;
		$upper_limit = 23;
		#@todo: these two should be set by the user dynamically. ajax? maybe to heavy
		
		
		
		
		#@todo: morgan: couldn't do that sortable thing with table rows. would be better though for the view of it, i think. 
		echo '<ul id="ajax_list" class="sortable">';

			$upc_match = new upc_match();
			
			$query = "
			SELECT
				u.id AS upc_id,
				m.id AS match_id,
				t1.name AS team1,
				t2.name AS team2,
				m.team1 AS team1_id,
				m.team2 AS team2_id
			FROM
				upc_matches AS u
				INNER JOIN matches AS m ON m.id = u.match_id
				INNER JOIN teams AS t1 ON m.team1 = t1.id
				INNER JOIN teams AS t2 ON m.team2 = t2.id
			WHERE
				m.bracket_id = '".$_SESSION['bracket_id']."'
			ORDER BY u.match_order ASC, u.id ASC
		";
	
    $result = $upc_match->fetch_results($query);
	
	
	

	$bracket = new bracket();
	$bracket->load_entry($_SESSION['bracket_id']);
	$timelimit1 = $bracket->get_timelimit1();
	$pause1 = $bracket->get_pause1();
	
	

	
	
	$blocks = array();
	$count = 0;
	$i = 0;
	$warning = 0;
	
	foreach ($result as $index => $data){
		

		
	    $scheduled_time = $start+(($timelimit1+$pause1)*60*$count);
	    
		
		if ($scheduled_time+(($timelimit1+$pause1)*60) > strtotime($playing_times[$current_playing_time_index]['end'])){
		
			$current_playing_time_index++;
			$scheduled_time = strtotime($playing_times[$current_playing_time_index]['begin']);
			$start = $scheduled_time;
			$count=0;
			$i++;
		}
		
		if (isset($playing_times[$current_playing_time_index])){
			$blocks[$i][] = $data;
			
			$count++;
		}else{
			$warning++;
		}
	}
	
	
	
	$teams = $tournament->get_registered_teams();
	$matches_per_block_temp = array();

	
	foreach ($teams as $team){
		$matches_per_block_temp[$team['id']]['name'] = $team['name'];
		$matches_per_block_temp[$team['id']]['played'] = 0;
	}
	
	
	$matches_per_block = array();
	
	
	
	$i = 1;
	
		
	foreach ($blocks as $block_index => $block){
		
		$matches_per_block = $matches_per_block_temp;
		$list_output = '';
	
	    foreach ($block as $index => $data){	

	
	    	$pause_team1 = '- ';
			$pause_team2 = '- ';
			
			$dummy1 = 0;
			$dummy2 = 0;
	    	
	    	while (isset($block[$index-$dummy1-1])){
	    		
	    		if ($block[$index-$dummy1-1]['team1_id'] == $data['team1_id'] || $block[$index-$dummy1-1]['team2_id'] == $data['team1_id']){
	    			$pause_team1 = $dummy1;
	    			break;
	    		}
	    		$dummy1++;
	    	}
	    	
	    	while (isset($block[$index-$dummy2-1])){
	    		
	    		if ($block[$index-$dummy2-1]['team1_id'] == $data['team2_id'] || $block[$index-$dummy2-1]['team2_id'] == $data['team2_id']){
	    			$pause_team2 = $dummy2;
	    			break;
	    		}
	    		$dummy2++;
	    	}
	
	        if (is_numeric($pause_team1) && ($pause_team1 < $lower_limit || $pause_team1 > $upper_limit)){
	    		$pause_team1 = '<span class="red"><b>' . $pause_team1 . '</b></span>';
	    	}else{
	    		$pause_team1 = '<span class="green"><b>' . $pause_team1 . '</b></span>';
	    	}
	
	        if (is_numeric($pause_team2) && ($pause_team2 < $lower_limit || $pause_team2 > $upper_limit)){
	    		$pause_team2 = '<span class="red"><b>' . $pause_team2 . '</b></span>';
	    	}else{
	    		$pause_team2 = '<span class="green"><b>' . $pause_team2 . '</b></span>';
	    	}
	    	
	
	    	
	    	
	    	
	    	$tilnext_team1 = '- ';
	    	$tilnext_team2 = '- ';
	    	
	    	$dummy1 = 0;
			$dummy2 = 0;
	    	
	    	while (isset($block[$index+$dummy1+1])){
	    		
	    		if ($block[$index+$dummy1+1]['team1_id'] == $data['team1_id'] || $block[$index+$dummy1+1]['team2_id'] == $data['team1_id']){
	    			$tilnext_team1 = $dummy1;
	    			break;
	    		}
	    		$dummy1++;
	    	}
	    	
	    	while (isset($block[$index+$dummy2+1])){
	    		
	    		if ($block[$index+$dummy2+1]['team1_id'] == $data['team2_id'] || $block[$index+$dummy2+1]['team2_id'] == $data['team2_id']){
	    			$tilnext_team2 = $dummy2;
	    			break;
	    		}
	    		$dummy2++;
	    	}
	    	
	    	
	    	
			if (is_numeric($tilnext_team1) && ($tilnext_team1 < $lower_limit || $tilnext_team1 > $upper_limit)){
	    		$tilnext_team1 = '<span class="red"><b>' . $tilnext_team1 . '</b></span>';
	    	}else{
	    		$tilnext_team1 = '<span class="green"><b>' . $tilnext_team1 . '</b></span>';
	    	}
	
			if (is_numeric($tilnext_team2) && ($tilnext_team2 < $lower_limit || $tilnext_team2 > $upper_limit)){
	    		$tilnext_team2 = '<span class="red"><b>' . $tilnext_team2 . '</b></span>';
	    	}else{
	    		$tilnext_team2 = '<span class="green"><b>' . $tilnext_team2 . '</b></span>';
	    	}
	    	
	    	
	    	
	    	
	    	
			$list_output .= '<li id="item_'. $data['match_id'] .'">'. $i. '.) ' . $data['team1'] .' (P: '.$pause_team1.', N: '.$tilnext_team1.') : '.$data['team2'].' (P: '.$pause_team2.', N: '.$tilnext_team2.')</li>';
			$list_output .= "\n";
			
			$matches_per_block[$data['team1_id']]['played']++;
			$matches_per_block[$data['team2_id']]['played']++;
			$i++;

		}
		
		
			echo '<div style="float: right; clear: both; margin-bottom: 20px;">';
			
			echo 'Games played by every team in block ' . ($block_index+1) . ': <br /><br />';
			
			$teams = array();
			$played = array();
	
			foreach ($matches_per_block as $key => $row) {

				$teams[$key] = $row['name'];
				$played[$key] = $row['played'];

			}
			
			array_multisort($teams, $played);
			#SORT_ASC, SORT_NUMERIC,
			
			foreach ($teams as $key3 => $team){
				echo $team . ': ' . $played[$key3] . '<br />';
			}
			
			echo '</div>';
		
		
		
		echo $list_output . '<br style="clear: both;" />';
	}
	
	if ($warning != 0){
		#@todo: lang. file
		echo '<span class="red">WARNING: '.$warning.' matches missing in this list. Please adjust your playing times</span>';
	}
	




?>
</ul>

<script type="text/javascript">
Sortable.create("ajax_list",
	{
	onUpdate:function()
		{
		new Ajax.Request('/greifmasters/inc/functions/ajax/matches_sort.function.inc.php',
			{
			method: "post",
			parameters: {data: Sortable.serialize("ajax_list")}
			});

		}

	});
</script>

<?php 
		
		




		
		return;
		
		
	}
	
	?>

<table class="ranking">
	<tr>
		<th>No.</th>
		<th>Time</th>
<!--		<th>Court</th>-->
		<th>Team 1</th>
		<th>Team 2</th>
	</tr>
	
	
<?php
	
	$query = "

		SELECT
			t1.name AS team1,
			t2.name AS team2,
			m.team1 AS team1_id,
			m.team2 AS team2_id,
			u.ready_team1 AS ready_team1,
			u.ready_team2 AS ready_team2
		FROM
			upc_matches AS u
			INNER JOIN matches AS m ON m.id = u.match_id
			INNER JOIN teams AS t1 ON m.team1 = t1.id
			INNER JOIN teams AS t2 ON m.team2 = t2.id
		WHERE
			m.bracket_id = '".$_SESSION['bracket_id']."'
		ORDER BY u.match_order ASC, u.id ASC
		
	";
	#,c.name AS court INNER JOIN courts AS c ON c.id = u.court_id
	
	$bracket = new bracket();
	$bracket->load_entry($_SESSION['bracket_id']);
	$timelimit1 = $bracket->get_timelimit1();
	$pause1 = $bracket->get_pause1();

	$upc_matches = new upc_match ( );
	$upc_matches = $upc_matches->fetch_results ( $query );
	
	$i=0;
	$count=0;
	$ready_signal_offset = 3;
	#@todo: ready signal: teams for the next 3 matches are meant to report ready to the ref. number should be adjustable of course
	
	
	$tournament = new tournament();
	$playing_times = $tournament->get_playing_times();

	
	foreach ($playing_times as $index => $timespan){
		if (time() < strtotime($timespan['end']) && time() > strtotime($timespan['begin'])){
			$start = time();
			$current_playing_time_index = $index;
		}elseif(!isset ($start) && time() < strtotime($timespan['begin'])){
			$start = strtotime($timespan['begin']);
			$current_playing_time_index = $index;
		}

		
		#@todo: if now() is not during any playing time period $start will be the beginning of the first playing time period, no matter if this period of time is already over. example: sunday early morning. sunday playing time didn't start yet. $start is fri 13:00
	}

	
	
	foreach ( $upc_matches as $index => $upc_match ) {
		
		if ($playing_times != FALSE){
			
			$scheduled_time = $start+(($timelimit1+$pause1)*60*$count);
			$scheduled_time_formated = date('D, H:i', $scheduled_time);
	
			if ($scheduled_time+(($timelimit1+$pause1)*60) > strtotime($playing_times[$current_playing_time_index]['end'])){
				
				$current_playing_time_index++;
				if ($playing_times[$current_playing_time_index] == NULL){
					$scheduled_time_formated = '<span class="red">N/A</span>';
				}else{
					$scheduled_time = strtotime($playing_times[$current_playing_time_index]['begin']);
					$scheduled_time_formated = date('D, H:i', $scheduled_time);
					$start = $scheduled_time;
					$count=0;
				}
			}
		}else{
			$scheduled_time_formated = 'N/A';
		}
		
		echo '
		<tr>
			<td>'.($index+1).'.)</td>
			<td>' . $scheduled_time_formated . '</td>
			<td>';
		
			if ($i < $ready_signal_offset){
				if ($upc_match ['ready_team1'] == 1) {
					echo '<span class="green">' . $upc_match ['team1'] . '</span>';
				} else {
					echo '<span class="red">' . $upc_match ['team1'] . '</span>';
				}
			}else{
				echo $upc_match ['team1'];
			}
			
			echo'
			</td><td>';
			
			if ($i < $ready_signal_offset){
				if ($upc_match ['ready_team2'] == 1) {
					echo '<span class="green">' . $upc_match ['team2'] . '</span>';
				} else {
					echo '<span class="red">' . $upc_match ['team2'] . '</span>';
				}
			}else{
				echo $upc_match ['team2'];
			}
			
			echo '
			</td>
		</tr>
		';
		$i++;
		$count++;
	}
	
	echo'
		</table>
		<a href="'.BASE.'/play_tournament/matches/upc/rearrange">rearrange schedule</a>
	';
}




?>
