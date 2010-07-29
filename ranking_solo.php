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
			gm_upc_matches AS u
			INNER JOIN gm_matches AS m ON m.id = u.match_id
			INNER JOIN gm_teams AS t1 ON m.team1 = t1.id
			INNER JOIN gm_teams AS t2 ON m.team2 = t2.id
		WHERE
			m.bracket_id = '".$_SESSION['bracket_id']."'
		ORDER BY u.match_order ASC, u.id ASC LIMIT 6
		
	";
	#,c.name AS court INNER JOIN courts AS c ON c.id = u.court_id
	
	$bracket = new bracket();
	$bracket->load_entry($_SESSION['bracket_id']);
	$timelimit1 = $bracket->get_timelimit1();
	$pause1 = $bracket->get_pause1();

	$upc_matches = new upc_match ( );
	$upc_matches = $upc_matches->fetch_results ( $query );
	
	$offset_count=0;
	$count=0;
	$ready_signal_offset = 3;

	
	
	$tournament = new tournament();
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

	
	
	foreach ( $upc_matches as $index => $upc_match ) {
		

		$scheduled_time = $start+(($timelimit1+$pause1)*60*$count);

		if ($scheduled_time > strtotime($playing_times[$current_playing_time_index]['end'])){
			$current_playing_time_index++;
			if ($playing_times[$current_playing_time_index] == NULL){
				$bracket = new bracket();
				$bracket->load_entry($_SESSION['bracket_id']);
				
				echo '<span class="red">not enough time for match no. '.$index . '</span>';
				break;
			}
			$scheduled_time = strtotime($playing_times[$current_playing_time_index]['begin']);
			$start = $scheduled_time;
			$count=0;
		}
		
		echo '
		<tr>
			<td>'.($index+1).'.)</td>
			<td>' . (date('D, H:i', $scheduled_time)) . '</td>
			<td>';
		
			if ($offset_count < $ready_signal_offset){
				if ($upc_match ['ready_team1'] == 1) {
					echo '<span class="green">' . $upc_match ['team1'] . '</span>';
				} else {
					echo '<span class="red">' . $upc_match ['team1'] . '</span>';
				}
			}else{
				echo $upc_match ['team1'];
			}
			
			echo'
			<td>-</td>
			</td><td>';
			
			if ($offset_count < $ready_signal_offset){
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
			<td>action</td>
		</tr>
		';
		$offset_count++;
		$count++;
	}
	
	?>
