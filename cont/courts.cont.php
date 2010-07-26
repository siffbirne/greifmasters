<?php

if (isset ($_GET['p1']) && $_GET['p1'] == 'create') {
	
	if (isset($_POST['submit']) && $_POST['submit'] == 1){

		
		$court = new court();

		$court->store($_POST['court_name'], $_POST['location']);

		header ( "Location: ".BASE."/courts/show/" . $court->insert_id);
		
	}
	include 'inc/forms/create_new_court.form.inc.php';
	return;
	
}

include 'cont/inc/tables/court_list.table.inc.php';
#include 'rgrid/court_list.grid.inc.php';

?>