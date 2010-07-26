<?php



if (
		isset($_GET['p1']) && 
		$_GET['p1'] == 'register' && 
		isset ( $_POST ['submit'] ) && 
		$_POST ['submit'] == 1
	){

	$form_entries = $_POST;
	
	var_dump($form_entries);
	$new_tournament = new tournament();
	$new_tournament->store(
		$form_entries['name'],
		$form_entries['city'],
		$form_entries['begin_select_year'].'-'.$form_entries['begin_select_month'].'-'.$form_entries['begin_select_day'],
		$form_entries['end_select_year'].'-'.$form_entries['end_select_month'].'-'.$form_entries['end_select_day'],
		$form_entries['spots_available']
	);
		
	$_SESSION['notification']=1;
//	header('Location: '.BASE.'/tournament/show/'.$new_tournament->get_id());
	
	return;
		
}



	
include 'inc/forms/register_new_tournament.form.inc.php';




?>