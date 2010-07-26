<form method="post" action="/greifmasters/admin/setup/register">
<input type="hidden" name="submit" value="1" />

<table>
	<tr>
		<td>Tournament name:</td>
		<td><input type="text" name="name" /></td>
	</tr>
	<tr>
		<td>City:</td>
		<td><input type="text" name="city" /></td>
	</tr>
	<tr>
		<td>Starts:</td>
		<td><?php date_dropdown_bar('begin');?></td>
	</tr>
	<tr>
		<td>Ends:</td>
		<td><?php date_dropdown_bar('end');?></td>
	</tr>
	<tr>
		<td>Available Spots</td>
		<td><input type="text" name="spots_available" /></td>
	</tr>
	<tr>
		<td colspan="2"><input type="submit" value="Register new tournament" /></td>
	</tr>
	
</table>


</form>