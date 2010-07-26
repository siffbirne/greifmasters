<form action="<?php echo BASE?>/play_tournament/brackets/new/" method="post">
<input type="hidden" name="nextstep" value="1" />
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
			<?php
			#@todo: bracketing should be in bracket classes
			
				$dir = openDir(DIR_BRACKETING);
				
				while ($file = readDir($dir)) {
					if ($file != "." && $file != "..") {
						if (strstr($file, ".php")) {
							$code = explode(".", $file);
							$code = $code[0];
							require_once DIR_BRACKETING.'/'.$file;
							echo '<option value="'.$code.'">'.$bracket_type.'</option>';
						}
						
					}
				}
				
				closeDir($dir);
			?>
			</select>
		</td>
	</tr>
	<tr>
		<td colspan="2">temp. hack: include every team</td>
	</tr>
	<tr>
		<td colspan="2"><input type="submit" value="Submit" /></td>
	</tr>


</table>


</form>