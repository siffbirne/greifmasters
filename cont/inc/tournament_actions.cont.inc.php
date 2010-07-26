<?php

$tournament_id = $tournament->get_id();

switch ($tournament->get_status()) {
	case 0:
		$startstop = '
			<span class="grey1">registration still open</span>
		';

		$registration = '
			<a href="/greifmasters/admin/tournament/'.$tournament_id.'/status/1">close registration</a>
		';
	break;

	case 1:
		$startstop = '
			<a href="/greifmasters/admin/tournament/'.$tournament_id.'/status/2">start tournament</a>
		';

		$registration = '
			<a href="/greifmasters/admin/tournament/'.$tournament_id.'/status/0">re-open registration</a>
		';
	break;


	case 2:
		$startstop = '
			<a href="/greifmasters/admin/tournament/'.$tournament_id.'/status/3">end tournament</a><br />
			<a href="/greifmasters/admin/play_tournament/'.$tournament_id.'">PLAY THIS TOURNAMENT!!</a><br />
			<a href="/greifmasters/admin/tournament/'.$tournament_id.'/reset">reset tournament</a>
		';

		$registration = '&nbsp;';

	break;

	case 3:
		$startstop = '
			<a href="/greifmasters/admin/tournament/'.$tournament_id.'/reset">reset tournament</a>
		';

		$registration = '&nbsp;';


	break;

}
#@todo: links in this file have greifmasters in the path. use BASE

echo "\n".'
	<table>
		<tr>
			<th colspan="2">Actions</th>
		</tr>
		<tr>
			<td>'.$startstop.'</td>
			<td><a href="/greifmasters/admin/tournament/'.$tournament_id.'/edit">edit tournament information</a></td>
		</tr>
		<tr>
			<td>'.$registration.'</td>
			<td><a href="/greifmasters/admin/tournament/'.$tournament_id.'/massmail">send newsletter to teams</a></td>
		</tr>
		<tr>
			<td><a href="/greifmasters/admin/tournament/'.$tournament_id.'/delete">delete this tournament</a></td>
			<td><a href="/greifmasters/admin/tournament/'.$tournament_id.'/playing_times">set up playing times</a></td>
		</tr>
	</table>
'."\n";


?>