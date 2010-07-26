<table class="t1">
	<tr>
		<th>Name</th>
		<th>City</th>
		<th>Players</th>
	</tr>
	
	
<?php

$teams = new db('teams');
$teams = $teams->select('id');

foreach ($teams as $team){
	$temp = new team();
	$temp->load_entry($team['id']);
	$players = $temp->get_players();
	$edit = BASE.'/teams/'.$team['id'];
	echo'
		<tr>
			<td><a href="'.$edit.'">'.$temp->get_name().'</a></td>
			<td>'.$temp->get_city().'</td>
			<td>'.$players['player1'].', '.$players['player2'].', '.$players['player3'].'</td>
		</tr>
	';
}

echo '</table>
		';

?>