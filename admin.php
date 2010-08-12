<?php
$messung = microtime();
$messung = explode (' ', $messung);
$messung = $messung[1] + $messung[0];
$beginn = $messung; 

#FIXME: not one single form is checked. neither if it is completed, nor if it contains forbidden characters. xss, sql-inj, ... !!

error_reporting(E_ALL ^ E_NOTICE);
session_start ();
ob_start();
require 'inc/functions.inc.php';

if ($_SESSION['rights'] == 'admin'){$_SESSION['admin']=TRUE;}

#@FIXME: total lack of proper rights management. just a crappy hack:

if (!isset ( $_SESSION ['user'] )) {
	$_SESSION ['cat'] = 'login';
}else{
	if (isset ( $_GET ['cat'] )) {
		$_SESSION ['cat'] = htmlentities($_GET['cat']);
	}else{
		$_SESSION ['cat'] = '';
	}
	
	
	if ($_SESSION['rights'] == 'ref'){
		$ref = new ref();
		$ref->load_entry($_SESSION['user']);
		$court = $ref->get_court();
		$_SESSION['bracket_id'] = $ref->get_bracket();
		if ($_GET['cat'] != 'logout') {$_SESSION['cat'] = 'play_tournament';}
		$_GET['p1'] = 'matches';
		$_GET['p2'] = 'ong';
		$_GET['p3'] = $court;
	}
}

if (isset($_SESSION['notification'])){
	echo notifications($_SESSION['notification']);
	unset ($_SESSION['notification']);
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
	
	case 'login':
		include 'login.php';
	break;
	
	case 'logout':
		session_destroy();
		header ( "Location: ".PAGE_ROOT."/admin.php" );
	break;
	
	case 'test_code':
		include 'test_code.php';
	break;

	case 'debug_mode':
		
		if ($_SESSION['admin'] == TRUE){
			if ($_SESSION['debug_mode']){
				$_SESSION['debug_mode'] = FALSE;
			}else{
				$_SESSION['debug_mode'] = TRUE;
			}	
		}
		
		include 'cont/general.php';
	break;
	
	default :
		include 'cont/general.php';
	break;

}


$main_content = ob_get_contents();
ob_end_clean();

$messung = microtime();
$messung = explode(' ', $messung);
$messung = $messung[1] + $messung[0];
$ende = $messung;
$total_time = round(($ende - $beginn), 4);


if (!$notemplates){
	
	$page_title = 'Greifmasters Tournament Management v0.2';

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
	
	$page_footer = 'Greifmasters Tournament Management v0.2';
	if ($_SESSION['debug_mode']== TRUE){
		$page_footer = "get: ".print_r ($_GET, true)."<br>".
		"post: ".print_r ($_POST, true)."<br>".
		"session: ".print_r  ($_SESSION, true)."<br>".
		'<p>Page generated in '.$total_time.' seconds.</p>'."\n"; 
	}
	
	include 'inc/tpl/standard.tpl.php';

}else{
	echo $main_content;
}
?>
