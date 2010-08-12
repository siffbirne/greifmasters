<table class="t1">
	<tr>
		<th>Name</th>
		<th>City</th>
		<th>Players</th>
	</tr>
	
	
<?php

$refs = new db('teams');
$refs = $refs->select('id');

foreach ($refs as $ref){
	$temp = new team();
	$temp->load_entry($ref['id']);
	$players = $temp->get_players();
	$edit = BASE.'/teams/'.$ref['id'];
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