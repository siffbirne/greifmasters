<?php
$bracket_code = 'single_elimination';
$bracket_type = 'Single elimination';
$steps = 2;



if (isset($_SESSION['temp']['bracket'])){

if (isset($_SESSION['temp']['bracket']['nextstep'])){
	
	$bracket = new single_elimination();
	$bracket->load_entry($_SESSION['temp']['bracket']['id']);
	
	$nextstep = $bracket->get_status() + 1;
	
	
	switch ($nextstep){
		
			case 2:
				$bracket->set_status(2);
				$_SESSION['temp']['bracket']['nextstep'] = 3;
				
				$top = $_POST['top'];
				$bracket->set_qualified_teams('top', $top, $_POST['bracket']);
				
				
				echo 'Time limits:<br />';
				echo'
					<form action="' . BASE . '/play_tournament/brackets/new/" method="post">
					<table>
						<tr>
							<th>round</th><th>time limit</th><th>pause</th>
						</tr>
				';
				
				$i=1;
				while ( $top/2 >= 2 && $i<5){
					echo '
						<tr>
							<td>best '.$top.'<td>
							<td><input type="text" name="timelimit_'.$i.'" maxlength="2" /></td>
							<td><input type="text" name="pause_'.$i.'" maxlength="2" /></td>
						</tr>
					';
					$top = $top/2;
					$i++;
				}
				echo '
						<tr>
							<td>FINAL<td>
							<td><input type="text" name="timelimit_5" maxlength="2" /></td>
							<td><input type="text" name="pause_5" maxlength="2" /></td>
						</tr>
				';
				
				echo'
					</table>
					<input type="submit" value="Submit" />
					
					</form>';
			break;
	
			
			case 3:

				$bracket->set_status(3);
				
				foreach ($_POST as $key=>$value){
					$help = explode('_', $key);
					if ($help[0] == 'timelimit'){
						$method = 'set_timelimit'.$help[1];
						$bracket->$method($value);
					}elseif($help[0] == 'pause'){
						$method = 'set_pause'.$help[1];
						$bracket->$method($value);
					}
				}

				$bracket->draw_bracket();
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
	
	$bracket = new single_elimination();
	$bracket->setup($_SESSION['temp']['bracket']['name'], $bracket_code);
	$_SESSION['temp']['bracket']['id'] = $bracket->get_id();
	
	echo'
		<form action="'.BASE.'/play_tournament/brackets/new/" method="post">
		Admitted teams for this bracket:<br />
		top <select name="top">
	';
	for ($i=1; $i<8; $i++){
		echo '<option>'.pow(2,$i).'</option>';
	}
	echo '</select> teams from bracket: <select name="bracket">
	';
	
	$tournament = new tournament();
	$tournament->load_entry($_SESSION['tournament_id']);
	$brackets = $tournament->get_brackets();
	
	foreach ($brackets as $row){
		if ($row['id'] != $bracket->get_id()){
			echo '<option value="'.$row['id'].'">'.$row['name'].'</option>'."\n";
		}
	}
	
	echo '</select><input type="submit" value="Continue" /></form>';
	
}
}
?>