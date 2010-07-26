<?php
#FIXME: everything in this file is completely experimental. included files containing forms are just temporary. everything pretty much hacked together


if(isset($_POST['type'])){
	$_SESSION['temp']['bracket']['type'] = $_POST['type'];
}


if (isset($_SESSION['temp']['bracket']['type'])){
	
	include DIR_BRACKETING.'/'.$_SESSION['temp']['bracket']['type'].'.php';
	
//	switch ($_SESSION['temp']['bracket']['type']){
//		
//		case 'karlsruher_system':
//			
//			
//			
//			
//			$bracket = new karlsruher_system();
//			
//				switch ($_SESSION['temp']['bracket']['nextstep']){
//				
//				
//				
//				case 1:
//					$_SESSION['temp'] = array();
//					$_SESSION['temp']['bracket'] = array();
//					$_SESSION['temp']['bracket']['offset'] = $_POST['offset'];
//					$_SESSION['temp']['bracket']['type'] = 'karlsruher_system';
//					
//					$bracket->store_step1($_POST['bracket_name']);
//					$bracket->set_bracket_type(1);
//					$_SESSION['temp']['bracket']['bracket_id'] = $bracket->get_id();
//		
//				
//				case 2:
//					
//					
//					
//
//		//			
//		//			$bracket->seeding_step1();
//		
//					include 'inc/forms/new_bracket_step2_kasys_temp.form.inc.php';
//					
//		//			if (isset($_SESSION['test']['seeding'])){
//		//				include 'inc/forms/new_bracket_step2_2.form.inc.php';
//		//			}else{
//		//				
//		//				include 'inc/forms/new_bracket_step2_1.form.inc.php';
//		//			}
//		
//				break;
//				
//				case 3:
//					
//					$_SESSION['temp']['bracket']['offset'] = $_POST['offset'];
//		
//					include 'inc/forms/new_bracket_step3.form.inc.php';
//				break;
//				
//				case 4:
//					
//					
//					$bracket->load_entry($_SESSION['temp']['bracket']['bracket_id']);
//					$bracket->set_timelimit1($_POST['timelimit1']);
//					$bracket->set_pause1($_POST['pause1']);
//					
//					
//					$bracket->draw_bracket($_SESSION['temp']['bracket']['bracket_id'], $_SESSION['temp']['bracket']['offset'],TRUE);
//					$bracket->set_status(4);
//					
//					unset ($_SESSION['temp']['bracket']);
//					
//					
//				break;
//			}
//			
//			
//			
//		break;
//		
//		case 'single_elimination':
//			
//			
//	$bracket = new single_elimination();
//			
//				switch ($_SESSION['temp']['bracket']['nextstep']){
//				
//				
//				
//				case 1:
//					$_SESSION['temp'] = array();
//					$_SESSION['temp']['bracket'] = array();
//					$_SESSION['temp']['bracket']['type'] = 'single_elimination';
//					
//					$bracket->store_step1($_POST['bracket_name']);
//					$bracket->set_bracket_type(2);
//					$_SESSION['temp']['bracket']['bracket_id'] = $bracket->get_id();
//					
//					include 'inc/forms/new_bracket_step1_singleel_temp.form.inc.php';
//				break;
//				
//				case 2:
//
//					$bracket->load_entry($_SESSION['temp']['bracket']['bracket_id']);
//					
//					$bracket->set_timelimit1($_POST['timelimit1']);
//					$bracket->set_pause1($_POST['pause1']);
//					$bracket->set_timelimit2($_POST['timelimit2']);
//					$bracket->set_pause2($_POST['pause2']);
//					$bracket->set_timelimit3($_POST['timelimit3']);
//					$bracket->set_pause3($_POST['pause3']);
//					$bracket->set_timelimit4($_POST['timelimit4']);
//					$bracket->set_pause4($_POST['pause4']);
//					$bracket->set_timelimit5($_POST['timelimit5']);
//					$bracket->set_pause5($_POST['pause5']);
//					
//					$bracket->set_status(2);
//
//		
//					include 'inc/forms/new_bracket_step2_singleel_temp.form.inc.php';
//				break;
//				
//				case 3:
//					
//					$bracket->load_entry($_SESSION['temp']['bracket']['bracket_id']);
//
//					
//					$reference_bracket = new bracket();
//					$reference_bracket->load_entry($_POST['reference_bracket']);
//					$ranking = $reference_bracket->get_ranking($_POST['top_x'], TRUE);
//					
//
//					$bracket->draw_bracket($ranking);
//					$bracket->set_status(4);
//					
//					unset ($_SESSION['temp']['bracket']);
//					
//					
//				break;
//			}
//			
//			
//		break;
//		
//		default:
//			die ('Bracket type not set correctly');
//		break;
//	}

	


	
//	echo "number of matches: ".$qualification->get_number_of_matches()."<br>";
//	echo 'you will need '.$qualification->get_calculated_time('H:i').' hours of playing time.<br /><br>';
		

	return;
	
	
	
}else{
	include 'inc/forms/new_bracket_step1.form.inc.php';
	return;
}




?>