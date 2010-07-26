<form method="post" action="<?php echo BASE ; ?>/courts/create">


<input type="hidden" name="submit" value="1" />

<table>
	<tr>
		<td>Court name:</td>
		<td><input type="text" name="court_name" /></td>
	</tr>
	<tr>
		<td>Location:</td>
		<td><input type="text" name="location" /></td>
	</tr>
	<tr>
		<td colspan="2"><input type="submit" value="Create new court" /></td>
	</tr>

</table>


</form>