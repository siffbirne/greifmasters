<form action="<?php echo BASE?>/play_tournament/brackets/new/" method="post">
<input type="hidden" name="submit" value="1" />
<table>
	<tr>
		<td>Name of bracket:</td>
		<td><input type="text" name="bracket_name" /></td>
	</tr>
	<tr>
		<td>type:</td>
		<td>
			<select name="type">
			<option></option>
			<option value="karlsruher_system">Karlsruher System</option>
			<option value="single_elimination">Single elimination</option>
			</select>
		</td>
	</tr>
	<tr>
		<td colspan="2">time limits: (if you only have one round, just enter timelimit for "last round". Timelimits can still be adjusted later on. Values for "pause" are just for schedule calculation)</td>
	</tr>
	<tr>
		<td>last round <span class="red">*</span>:</td>
		<td>
			Timelimit: <input type="text" name="timelimit5" maxlength="2" /><br />
			Pause between matches: <input type="text" name="pause5" maxlength="2" />
		</td>
	</tr>
	<tr>
		<td>before:</td>
		<td>
			Timelimit: <input type="text" name="timelimit4" maxlength="2" /><br />
			Pause between matches: <input type="text" name="pause4" maxlength="2" />
		</td>
	</tr>
	<tr>
		<td>before:</td>
		<td>
			Timelimit: <input type="text" name="timelimit3" maxlength="2" /><br />
			Pause between matches: <input type="text" name="pause3" maxlength="2" />
		</td>
	</tr>
	<tr>
		<td>before:</td>
		<td>
			Timelimit: <input type="text" name="timelimit2" maxlength="2" /><br />
			Pause between matches: <input type="text" name="pause2" maxlength="2" />
		</td>
	</tr>
	<tr>
		<td>before:</td>
		<td>
			Timelimit: <input type="text" name="timelimit1" maxlength="2" /><br />
			Pause between matches: <input type="text" name="pause1" maxlength="2" />
		</td>
	</tr>
	<tr>
		<td colspan="2"><input type="submit" value="Submit" /></td>
	</tr>


</table>


</form>