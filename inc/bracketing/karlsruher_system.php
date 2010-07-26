<?php
$bracket_code = 'karlsruher_system';
$bracket_type = 'Karlsruher System';
$steps = 2;



if (isset($_SESSION['temp']['bracket'])){

if (isset($_SESSION['temp']['bracket']['nextstep'])){
	
	$bracket = new karlsruher_system();
	$bracket->load_entry($_SESSION['temp']['bracket']['id']);
	
	$nextstep = $bracket->get_status() + 1;
	
	
	switch ($nextstep){
		
			case 2:
				$bracket->set_status(2);
				$_SESSION['temp']['bracket']['nextstep'] = 3;
				$_SESSION['temp']['bracket']['offset'] = $_POST['offset'];

				
				echo'
					<form action="' . BASE . '/play_tournament/brackets/new/" method="post">
					<table>
						<tr>
							<td>time limit:</td>
							<td><input type="text" name="timelimit" maxlength="2" /></td>
						</tr>
						<tr>
							<td>Pause between matches:</td>
							<td><input type="text" name="pause" maxlength="2" /></td>
						</tr>
					</table>
					<input type="submit" value="Submit" />
					
					</form>';
			break;
	
			
			case 3:

				$bracket->set_status(3);
				$bracket->set_timelimit1($_POST['timelimit']);
				$bracket->set_pause1($_POST['pause']);

				$bracket->draw_bracket($_SESSION['temp']['bracket']['offset']);
				$bracket->set_status(0);

				header ("Location: ".BASE."/play_tournament/brackets/".$_SESSION['temp']['bracket']['id']);
				unset ($_SESSION['temp']['bracket']);
				
			break;
		}

}else{
	
	#@todo: post eingaben prüfen!!
	$_SESSION['temp'] = array();
	$_SESSION['temp']['bracket'] = array();
	$_SESSION['temp']['bracket']['type'] = $bracket_code;
	$_SESSION['temp']['bracket']['name'] = $_POST['bracket_name'];
	$_SESSION['temp']['bracket']['nextstep'] = 2;
	
	$bracket = new karlsruher_system();
	$bracket->setup($_SESSION['temp']['bracket']['name'], $bracket_code);
	$_SESSION['temp']['bracket']['id'] = $bracket->get_id();
	
	$bracket->set_qualified_teams('all');
	
?>
	
	<form action="<?php echo BASE?>/play_tournament/brackets/new/" method="post">
	Select offset:<br />
	<select name="offset">
		<option value="1">1</option>
		<option value="2">2</option>
		<option value="3">3</option>
		<option value="4">4</option>
		<option value="5">5</option>
		<option value="6">6</option>
	</select><br />
	
	set order of teams:<br /><br />
	
	<ul id="ajax_list">

<?php

	$bracket->seeding();
    $seeding = $bracket->get_seeding();
    
	$i = 1;
    foreach ($seeding as $data)
    {
    	$team = new team();
		echo '<li id="item_'. $data['id'] .'">'. $i. '.) ' . $team->get_name_by_id($data['team_id']) .'</li>';
		echo "\n";
		$i++;
	}
?>
	</ul>
	
	<script type="text/javascript">
	Sortable.create("ajax_list",
		{
		onUpdate:function()
			{
			new Ajax.Request('/greifmasters/inc/functions/ajax/seeding_sort.function.inc.php',
				{
				method: "post",
				parameters: {data: Sortable.serialize("ajax_list")}
				});
			}
		});
	</script>
	
	<input type="submit" value="Done seeding" />
	
	
	</form>
<?php
	
}
}
?>