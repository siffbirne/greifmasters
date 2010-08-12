<?php
//if (isset($_GET['team_id']) && is_numeric(htmlentities($_GET['team_id']))){
//	$team_id = htmlentities($_GET['team_id']);
//	$_SESSION['team_id'] = $team_id;
//}elseif(isset($_SESSION['team_id'])){
//	$team_id = $_SESSION['team_id'];
//}
//else{
//	$_SESSION['notification']=2;
//	header ( "Location: /greifmasters/admin/tournament/$tournament->id/" );
//	break;
//}


	// actions ----------------------------------------------------------------

	if( isset ($_GET ['p1']) &&  $_GET ['p1'] != '') {
		
		if ($_GET ['p1'] == 'delete' && is_numeric(($_GET ['p2']))){
			
			$ref = new ref();
			$ref->load_entry($_GET ['p2']);
			$ref->delete();
			
		}elseif (isset ( $_POST ['submit'] )) {
				
			$name = $_POST['name'];
			$court = $_POST['court'];
			$pass = $_POST['passwords'];
			$passwords = password_generator($name, $pass);
			
			
			
			if (isset($_POST['update'])){
				$ref = new ref();
				$ref->load_entry($_POST['update']);
				$ref->update("user='$name', court='$court'", "id='".$_POST['update']."', salt='$passwords[0]', pass='$passwords[1]'");
				
			}else{
				$ref = new ref();
				$ref->store($name, $court, $passwords);				
			}
				
			
			header ( "Location: ".BASE."/refs");

			
					
				
		} else {
			
			echo '<form method="post" action="'.BASE.'/refs/submit">';
			
			if( isset ($_GET ['p1']) && is_numeric($_GET ['p1'])) {
				
				$ref = new ref();
				$ref->load_entry($_GET ['p1']);
				$name = $ref->get_name();
				$court = $ref->get_court();
				$value = 'Save';
				
				echo '<input type="hidden" name="update" value="'.$_GET ['p1'].'" />';
			}else{
				$name = '';
				$court = '';
				$value = 'Add new ref';
			}
			
			$tournament = new tournament();
			$tournament->load_entry($_SESSION['tournament_id']);
			$courts = $tournament->get_courts();
					
			?>
				
			<table>
				<tr>
					<td>Name:</td>
					<td><input type="text" name="name" value="<?php echo $name; ?>" /></td>
				</tr>
				<tr>
					<td>Court:</td>
					<td><select name="court">
					<?php
					foreach ($courts as $court){
						echo '<option value="'.$court['id'].'">'.$court['name'].'</option>'."\n";
					}
					
					?>
					</select></td>
				</tr>
				<tr>
					<td>Password:</td>
					<td><input type="password" name="password" /></td>
				</tr>
				<tr>
					<td colspan="2"><input type="submit" name="submit" value="<?php echo $value; ?>" /></td>
				</tr>
			
			</table>
			
			
			</form>
			<?php
		
		return;
		}

	}
	


	// display info -------------------------------------------------------

?>

	<table class="border">
	<tr>
		<th>Name</th>
		<th>Court</th>
		<th>&nbsp;</th>
	</tr>
	
	
<?php

$refs = new db('users');
$refs = $refs->select('id', "rights = 'ref'");

foreach ($refs as $ref){
	$temp = new ref();
	$temp->load_entry($ref['id']);
	$edit = BASE.'/refs/'.$ref['id'];
	
	$court = new court();
	$court->load_entry($temp->get_court());
	$court = $court->get_name();
	echo'
		<tr>
			<td><a href="'.$edit.'">'.$temp->get_name().'</a></td>
			<td>'.$court.'</td>
			<td><a href="'.BASE.'/refs/delete/'.$ref['id'].'"><img src="'.GFX_DELETE.'" /></a></td>
		</tr>
	';
}

echo '</table>
		';
	
	
	


?>