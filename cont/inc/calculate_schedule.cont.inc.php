<?php


if (isset($_GET['value'])){
	
	$qualification = new karlsruher_system(3);
	$qualification->store($_SESSION['tournament_id'],1);
	$qualification->draw_bracket();
	
	$tournament = new tournament();
	$tournament->load_entry($_SESSION['tournament_id']);
	$tournament->set_status(2);
	
	
	
	
	

	
//	echo "number of matches: ".$qualification->get_number_of_matches()."<br>";
//	echo 'you will need '.$qualification->get_calculated_time('H:i').' hours of playing time.<br /><br>';
		

	return;
	
	
	
}

echo '
	<table>
		<tr>
			<th>Vorrunde</th>
			<td><a href="'.BASE.'/tournament/'.$_SESSION['tournament_id'].'/calculate_schedule/1">karlsruher system</a></td>
		</tr><tr>
			<th>Finalrunde</th>
			<td>
				single elimination<br />
				double elimination
			</td>
		</tr>
	</table>
';


?>