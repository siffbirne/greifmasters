<table class="goals-form">
	<tr>
		<form method="post" action="<?php echo BASE; ?>/play_tournament/matches/ong/goal/store">
		<input type="hidden" name="team" value="<?php echo $team; ?>" />
		<input type="hidden" name="player" value="<?php echo $players['player1_id']; ?>" />
		
			<td><?php echo $players['player1']; ?>:</td>
			<td><input type="submit" class="change_goal" name="goal" value="Goal!" /></td>
			<td><input type="checkbox" name="owngoal" value="1" /></td>
			
		</form>
	</tr>
	<tr>
		<form method="post" action="<?php echo BASE; ?>/play_tournament/matches/ong/goal/store">
		<input type="hidden" name="team" value="<?php echo $team; ?>" />
		<input type="hidden" name="player" value="<?php echo $players['player2_id']; ?>" />
		
			<td><?php echo $players['player2']; ?>:</td>
			<td><input type="submit" class="change_goal" name="goal" value="Goal!" /></td>
			<td><input type="checkbox" name="owngoal" value="1" /></td>
			
		</form>
	</tr>
	<tr>
		<form method="post" action="<?php echo BASE; ?>/play_tournament/matches/ong/goal/store">
		<input type="hidden" name="team" value="<?php echo $team; ?>" />
		<input type="hidden" name="player" value="<?php echo $players['player3_id']; ?>" />
		
			<td><?php echo $players['player3']; ?>:</td>
			<td><input type="submit" class="change_goal" name="goal" value="Goal!" /></td>
			<td><input type="checkbox" name="owngoal" value="1" /></td>
			
		</form>
	</tr>
</table>
