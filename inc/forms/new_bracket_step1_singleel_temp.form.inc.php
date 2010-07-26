<form action="<?php echo BASE?>/play_tournament/brackets/new/" method="post">
<input type="hidden" name="nextstep" value="2" />
<table>
	<tr>
		<td colspan="2">time limits: (if you only have one round, just enter timelimit for "last round". Timelimits can still be adjusted later on. Values for "pause" are just for schedule calculation)</td>
	</tr>
	<tr>
		<td>final <span class="red">*</span>:</td>
		<td>
			Timelimit: <input type="text" name="timelimit1" maxlength="2" /><br />
			Pause between matches: <input type="text" name="pause1" maxlength="2" />
		</td>
	</tr>
	<tr>
		<td>semi finals</td>
		<td>
			Timelimit: <input type="text" name="timelimit2" maxlength="2" /><br />
			Pause between matches: <input type="text" name="pause2" maxlength="2" value=""/>
		</td>
	</tr>
	<tr>
		<td>quarter finals</td>
		<td>
			Timelimit: <input type="text" name="timelimit3" maxlength="2" /><br />
			Pause between matches: <input type="text" name="pause3" maxlength="2" value="" />
		</td>
	</tr>
	<tr>
		<td>eight final:</td>
		<td>
			Timelimit: <input type="text" name="timelimit4" maxlength="2" /><br />
			Pause between matches: <input type="text" name="pause4" maxlength="2" value="" />
		</td>
	</tr>
	<tr>
		<td>best 32:</td>
		<td>
			Timelimit: <input type="text" name="timelimit5" maxlength="2" /><br />
			Pause between matches: <input type="text" name="pause5" maxlength="2" value="" />
		</td>
	</tr>
</table>
<input type="submit" value="Submit" />

</form>