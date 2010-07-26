<?php

if (isset($_GET['p1'])){
	$argument = htmlentities($_GET['p1']);
}else{
	$argument = '';
}

switch ($argument){

	case 'upc':
		echo tournaments_table('upc');
	break;

	case 'ong':
		echo tournaments_table('ong');
	break;

	default:
		echo tournaments_table();
	break;

}


?>