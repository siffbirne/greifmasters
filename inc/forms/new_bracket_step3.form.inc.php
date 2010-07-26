<form action="<?php echo BASE?>/play_tournament/brackets/new/" method="post">
<input type="hidden" name="nextstep" value="4" />
<table>
	<tr>
		<td>time limit:</td>
		<td><input type="text" name="timelimit1" maxlength="2" /></td>
	</tr>
	<tr>
		<td>Pause between matches:</td>
		<td><input type="text" name="pause1" maxlength="2" /></td>
	</tr>
</table>
<input type="submit" value="Submit" />

</form>