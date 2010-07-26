<?php

#@FIXME: what is this???


require "inc/classes/karlsruher_system.class.php";
$bracket = new karlsruher_system();
$bracket->load_entry($_SESSION['bracket_id']);

switch($_GET['p1'])
{
	case 'rank':
		echo json_encode($bracket->get_ranking($_GET['p2']));
		die();
	break;

	case 'upcoming':
		include "ranking_solo.php";
	break;
}
?>
