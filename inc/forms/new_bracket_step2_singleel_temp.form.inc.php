<form action="<?php echo BASE?>/play_tournament/brackets/new/" method="post">
<input type="hidden" name="nextstep" value="3" />
Choose teams that will play this bracket:<br />

<table>
	<tr>
		<td colspan="2"><input type="radio" name="teams" value="all" /></td><td>all teams registered for the tournament: </td>
	</tr>
	<tr>
		<td><input type="radio" name="teams" value="selected" /></td>
		<td>
			qualified teams:<br />
			top 
				<select name="top_x">
				<option value="2">2</option>
				<option value="4">4</option>
				<option value="8">8</option>
				<option value="16">16</option>
				<option value="32">32</option>
				</select>
			teams from bracket
				<select name="reference_bracket">
					<?php
						$tournament = new tournament();
						$tournament->load_entry($_SESSION['tournament_id']);
						$brackets = $tournament->get_brackets();
						
						foreach ($brackets as $row){
							if ($row['id'] != $_SESSION['bracket_id']){
								echo '<option value="'.$row['id'].'">'.$row['name'].'</option>'."\n";
							}
						}
					?>
				</select>
		</td>
		<td>
			Seeding:<br />
			<input type="radio" name="seeding" value="automatic" /> automatic<br />
			<input type="radio" name="seeding" value="manual" /> manual
		</td>
	</tr>
	<tr><td colspan="2"><input type="submit" value="Proceed" /></td></tr>
</table>


</form>