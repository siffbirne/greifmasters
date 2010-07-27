<?php


#FIXME: not one single form is checked. neither if it is completed, nor if it contains forbidden characters. xss, sql-inj, ... !!

error_reporting(E_ALL);


session_start ();



$_SESSION['admin']=TRUE;
$_SESSION['user'] = 2;

require 'inc/functions.inc.php';

if (! isset ( $_SESSION ['user'] )) {
	header ( "Location: ".PAGE_ROOT."/login.php" );
	exit ();
}

if (isset ( $_GET ['logout'] ) && $_GET ['logout'] == 1) {
	session_destroy ();
	header ( "Location: $_SERVER[PHP_SELF]" );
	exit ();
}











ob_start();







if (isset($_SESSION['notification'])){

	echo notifications($_SESSION['notification']);
	unset ($_SESSION['notification']);

}




if (isset ( $_GET ['cat'] )) {
	$_SESSION ['cat'] = htmlentities($_GET['cat']);
}else{
	$_SESSION ['cat'] = '';
}


$navigation = '';

switch ($_SESSION['cat']) {
	case 'rpc' :
		include 'rpc.php';
		$noTemplates = true;
	break;

	case 'list_tournaments' :
		include 'cont/list_tournaments.cont.php';
	break;

	case 'tournament' :
		include 'cont/tournament.cont.php';
	break;
	
	case 'teams' :
		include 'cont/teams.cont.php';
	break;

	case 'team' :
		include 'cont/team.cont.php';
	break;

	case 'courts' :
		include 'cont/courts.cont.php';
	break;
		
	case 'settings' :
		include 'cont/settings.php';
	break;

	case 'setup' :
		include 'cont/setup.cont.php';
	break;

	case 'play_tournament':
		include 'cont/play_tournament.cont.php';
		$navigation = 'play_tournament.navigation.tpl.php';
	break;

	case 'logout':
		session_destroy();
		header ( "Location: ../login.php" );
	break;
	
	case 'test_code':
		include 'test_code.php';
	break;

	default :
		include 'cont/general.php';
	break;

}

if ($_SESSION['admin'] == TRUE){
	if ($_SESSION['cat'] == 'debug_mode'){
		if ($_SESSION['debug_mode']){
			$_SESSION['debug_mode'] = FALSE;
		}else{
			$_SESSION['debug_mode'] = TRUE;
		}
		include 'cont/general.php';
	}
}



$main_content = ob_get_contents();
ob_end_clean();



if (!$notemplates){
	
	$page_title = 'Greifmasters Tournament Management';

	if ($navigation != '') {
		$nav_file = TPL_INCLUDE_PATH . $navigation;
	}else{
		$nav_file = TPL_INCLUDE_PATH . 'navigation.tpl.php';
	}
	
	ob_start();
	include $nav_file;
	$col1_content = ob_get_contents();
	ob_end_clean();
	
	$col2_content = $main_content;
	
	$page_footer = 'Greifmasters Tournament Management v0.2, &copy; 2010 Max Thomas';
	if ($_SESSION['debug_mode']== TRUE){
		$page_footer = "get: ".print_r ($_GET, true)."<br>".
		"post: ".print_r ($_POST, true)."<br>".
		"session: ".print_r  ($_SESSION, true)."<br>";
	}
	
	include 'inc/tpl/standard.tpl.php';

}else{
	echo $main_content;
}
?>
