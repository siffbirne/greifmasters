<?php


if (isset($_GET['p2']) && $_GET['p2'] == 'new'){
	
	if (isset($_GET['p3']) && $_GET['p3'] == 'start'){
		unset ($_SESSION['temp']['bracket']);
	}
	
	
		if(isset($_POST['type'])){
			$_SESSION['temp']['bracket']['type'] = $_POST['type'];
		}
		
		#@todo: crap
		if (isset($_SESSION['temp']['bracket']['type'])){
			include DIR_BRACKETING.'/'.$_SESSION['temp']['bracket']['type'].'.php';
		}else{
			include 'inc/forms/new_bracket_step1.form.inc.php';
		}
			
	return;
}




if(isset($_GET['p2']) && is_numeric($_GET['p2'])){
	
#@todo:check
	$_SESSION['bracket_id'] = $_GET['p2'];
	
	$bracket = new bracket();
	$bracket->load_entry($_SESSION['bracket_id']);
	
	
	
	
	if (isset($_GET['p3']) && $_GET['p3']=='delete'){
		
		if (isset($_GET['p4']) && $_GET['p4'] == 1){
			$bracket->delete($_SESSION['bracket_id']);
			header("Location: ".BASE."/play_tournament/".$_SESSION['tournament_id']);
		}else{
			echo '
				<input type="hidden" name="delete" value="1" />
				Warning! This will delete all matches and corresponding results belonging to this bracket and can\'t be undone.<br />
				<a href="'. $_SERVER['REQUEST_URI'] .'/1">Yes, I am sure. Proceed</a>
			';
		}
		return;
	}
	
	if (isset($_GET['p3']) && $_GET['p3']=='settings'){
		
		if (isset($_POST['submit'])){
			
			$courts = new court_occupation();
			
			foreach ($_POST as $key=>$value){
				if ($value == 1){
					$courts->store($key);
				}
			}
			
		}else{
			
			$courts = new court();
			$courts = $courts->list_entries();
			
			echo 'caution! unless you know what youre doing only use once!<br /><form action="'.BASE.'play_tournament/brackets/'.$_SESSION['bracket_id'].'/settings" method="post">';
			
			foreach ($courts as $court){
				#@todo: check einbauen ob schon in benutzung
				echo '<input type="checkbox" name="'.$court['id'].'" value="1" /> '.$court['name'] . '<br />';
			}
			
			echo '<input type="submit" name="submit" value="Occupie courts" /></form>';
			
		}
		return;
	}
	
	
	
	
//	$status = $bracket->get_status();
//
//	if ($status != 0){
//			$_SESSION['temp']['bracket']['nextstep'] = $status;
//			$_SESSION['temp']['bracket']['id'] = $_SESSION['bracket_id'];
//			include 'cont/playtournament/new_bracket.playtournament.cont.inc.php';
//			return;
//	}

	
	
	$class = new bracket();
	$class->load_entry($_SESSION['bracket_id']);
	$bracket_type = $class->get_type();
	
	$bracket = new $bracket_type();
	$bracket->load_entry($_SESSION['bracket_id']);
	
	$bracket->draw_ranklist();

	
}



?>