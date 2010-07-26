<?php
error_reporting(E_ALL);


session_start ();


if (! isset ( $_SESSION ['admin'] ) || $_SESSION ['admin'] != TRUE) {
	header ( "Location: login.php" );
	exit ();
}

if (isset ( $_GET ['logout'] ) && $_GET ['logout'] == 1) {
	session_destroy ();
	header ( "Location: $_SERVER[PHP_SELF]" );
	exit ();
}


require_once 'inc/functions.inc.php';


function __autoload($class_name) {
    require_once 'inc/classes/' . $class_name . '.class.php';
}



ob_start();




if (isset ( $_GET ['page'] )) {
	$_SESSION ['page'] = htmlentities($_GET['page']);
}else{
	$cat = '';
}



switch ($_SESSION['page']) {
	case value:
	;
	break;
	
	default:
		;
	break;
}




include 'inc/tpl/head.tpl.php';
include 'inc/tpl/navigation.tpl.php';
echo '<div id="contentContainer">';
echo $contents;
echo '</div>';
include 'inc/tpl/bottom.tpl.php';