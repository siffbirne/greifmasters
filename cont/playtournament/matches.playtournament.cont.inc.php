<?php

if (isset ( $_GET ['p2'] ) && $_GET ['p2'] == 'ong') {
	include 'cont/playtournament/upnow.playtournament.cont.inc.php';
	return;

}

if (isset ( $_GET ['p2'] ) && is_numeric ( $_GET ['p2'] )) {
	
	if (isset ( $_GET ['p3'] ) && $_GET ['p3'] == 'reschedule') {
		
		$match = new match ( );
		$match->load_entry ( $_GET ['p2'] );
		$match->reschedule ();
		
		header ( "Location: " . BASE . "/play_tournament/matches/ong" );
		return;
	
	}
	
	$match = new match ( );
	$match->load_entry ( $_GET ['p2'] );
	
	$team1 = new team ( );
	$team1->load_entry ( $match->get_team1 () );
	$team2 = new team ( );
	$team2->load_entry ( $match->get_team2 () );
	
	$goals1 = $match->get_goals_1 ();
	$goals2 = $match->get_goals_2 ();
	
	echo '
		this is quite temporary...<table widht="300px">
			<tr>
				<td>' . $team1->get_name () . '</td>
				<td>&nbsp;</td>
				<td>' . $team2->get_name () . '</td>
			</tr>
			<tr>
				<td>
	';
	
	echo $goals1 ['count'] . ' (';
	foreach ( $goals1 ['goals'] as $goal ) {
		echo $goal ['player'] . ', ';
	}
	echo '
					)
				</td>
				<td>:</td>
				<td>
	';
	
	echo $goals2 ['count'] . ' (';
	foreach ( $goals2 ['goals'] as $goal ) {
		echo $goal ['player'] . ', ';
	}
	echo '
					)</td>
			</tr>
		</table><br />
	';
	
	switch ($match->get_status ()) {
		case 0 :
			echo 'match is scheduled';
			break;
		
		case 1 :
			echo '<a href="' . BASE . '/play_tournament/matches/' . $match->get_id () . '/reschedule">set back to "not finished" (match will be scheduled again; use this to modify results)</a>';
			break;
	}
	
	return;

} elseif (isset ( $_GET ['p2'] ) && $_GET ['p2'] == 'fin') {
	
	$bracket = new bracket();
	$bracket->load_entry($_SESSION ['bracket_id']);
	$bracket->get_match_results();

} elseif (isset ( $_GET ['p2'] ) && $_GET ['p2'] == 'upc') {
	
	$bracket = new bracket();
	$bracket->load_entry($_SESSION ['bracket_id']);
	
	if (isset ( $_GET ['p3'] ) && $_GET ['p3'] == 'rearrange') {
		
		if (isset ( $_GET ['p4'] ) && $_GET ['p4'] == 'sort'){
			
			
			parse_str($_POST['data']);

			$db = new db('upc_matches');
			
			for ($offset_count = 0; $offset_count < count($ajax_list); $offset_count++) {
				if(is_int($offset_count)) {
					$db->update("match_order = '$offset_count'", "match_id = '$ajax_list[$offset_count]'");
				}
				else {
				exit;
				}
			}
			
		}
		
		echo 'courts can not be changed in this view yet. coming soon...';
		
		if (isset ( $_POST ['additional_info'] )) {
			if ($_POST ['enable'] == 1) {
				$_SESSION ['additional_info'] ['lower_limit'] = $_POST ['lower_limit'];
				$_SESSION ['additional_info'] ['upper_limit'] = $_POST ['upper_limit'];
			} else {
				unset ( $_SESSION ['additional_info'] );
			}
		}
		
//	echo '
//		Display pause between matches of every team: <form action="' . BASE . 'play_tournament/matches/upc/rearrange" method="post">
//		<input type="checkbox" name="enable" value="1" />
//		i want everything between <input type="text" name="lower_limit" maxlength="2" value="' . $_SESSION ['additional_info'] ['lower_limit'] . '" />
//		 and <input type="text" name="upper_limit" maxlength="2" value="' . $_SESSION ['additional_info'] ['upper_limit'] . '" />
//		 <input type="submit" name="additional_info" value="Show" /></form>
//		';

		
		
		$schedule = $bracket->generate_schedule('','pause/next');
		
		$blocks = $schedule[0];
		$matches_per_block = $schedule[1];
		
		foreach ($blocks as $block_index => $block){

			foreach ($block as $court_index=> $court){
				echo '<div class="float_150px"><h3>Court '.$court_index.': </h3><br><ul id="ajax_list_'.$court_index.'" class="sortable">';
				foreach ($court as $match){
					echo '<li id="'.$match['id'].'" title="'.date ( 'D, H:i', $match['time']).': '.$match['team1'].' - '.$match['team2'].'">'.substr($match['team1'], 0, 10).'... - '.substr($match['team2'], 0, 10).'...</li>';
				}
				echo '</ul></div>';
			}
			echo '<div class="float">';
			
			foreach ( $matches_per_block[$block_index] as $team ) {
				echo $team['name'] . ': ' . $team['played'] . '<br />'."\n";
			}
			echo '</div>';
			echo '<br class="clear" />';
		}
		
		
		?>

</ul>
<script type="text/javascript">
Sortable.create("ajax_list",
	{
	onUpdate:function()
		{
		new Ajax.Request('<?= BASE ?>/play_tournament/matches/upc/rearrange/sort',
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
$bracket = new bracket();
$bracket->load_entry($_SESSION ['bracket_id']);

echo '
	<div id="topnav">';

$courts = $bracket->get_courts();
foreach ($courts as $court){
	echo '<a href="' . BASE . '/play_tournament/matches/upc/court/'.$court['id'].'">'.$court['name'].'</a> - '."\n";
}
echo '<a href="' . BASE . '/play_tournament/matches/upc">All courts</a> - '."\n";
echo'
	<a href="' . BASE . '/play_tournament/matches/upc/rearrange">rearrange schedule</a></div>
';

$bracket = new bracket();
$bracket->load_entry($_SESSION ['bracket_id']);

if (isset($_GET ['p3']) && $_GET ['p3'] == 'court'){
	$courts = $bracket->generate_schedule($_GET ['p4']);
}else{
	$courts = $bracket->generate_schedule();
}


	foreach ($courts as $key=>$row){
		
		$court = new court();
		$court->load_entry($key);
		$name = $court->get_name();
		
		echo'<div class="float_50perc"><h3>'.$name.'</h3><br />
			<table class="schedule">
				<tr>
					<th>No.</th>
					<th>Time</th>
					<th>Team 1</th>
					<th>Team 2</th>
				</tr>';
		
		foreach ($row as $row2){
			
			if ($row2['time'] == FALSE){
				$time = 'N/A';
			}else{
				$time = date ( 'D, H:i', $row2['time'] );
			}
			
			echo '<tr><td>'.$row2['index'].'</td><td>'.$time.'</td><td>'.$row2['team1'].'</td><td>'.$row2['team2'].'</td></tr>'."\n";
		}
		
		
		echo '</table></div>';
	}


}

?>
