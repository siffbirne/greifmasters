<?php


echo "\n".'
	<table class="tournament_outline">
		<tr>
			<th colspan="2">'.$tournament->get_name().'</th>
		</tr>
		<tr>
			<td>'.$tournament->get_city().'</td>
			<td rowspan="3">'.$tournament->get_begin().'<br />'.$tournament->get_end().'</td>
		</tr>
		<tr>
			<td>'.$tournament->get_number_of_teams().'/'.$tournament->get_spots_available().' teams registered</td>
		</tr>
		<tr>
			<td>'.translate_status($tournament->get_status()).'</td>
	 	</tr>
	</table>
'."\n";


?>