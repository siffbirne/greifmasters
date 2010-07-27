<?php

function __autoload($class_name) {
    require_once 'inc/classes/' . $class_name . '.class.php';
}



require 'functions/forms.function.inc.php';

#require 'functions/error_handler.function.inc.php';

require 'config.inc.php';
#require 'db.inc.php';
require 'variables.inc.php';

require 'functions/table.function.php';

require 'functions/date_dropdown_bar.function.php';
require 'functions/time_dropdown_bar.function.php';

require 'functions/tournaments_table.function.inc.php';
require 'functions/query_extension.function.inc.php';
require 'functions/translate_status.function.inc.php';

require 'functions/end_table.function.inc.php';
require 'functions/varcheck.function.inc.php';


require 'functions/brackets/shuffle_matchlist.function.inc.php';




date_default_timezone_set('Europe/Berlin');
#@todo: timezone actually should depend on the location of the tournament that is currently loaded


function check_form_entries($array,$form){

	#@todo: proper form check in js (morgan!)
	
	switch ($form) {
		case 'newtournament':
			$data = array('name','city', 'begin', 'end');
			$types = array(string, string, datetime, datetime);
		break;

	}


}


function notifications($code){
	
	#@todo: use for every notification! but in a better way, probably one file per language containing constants for every possible output. is to be loaded somewhere in this file.

	switch ($code){

		case 1:
			$return = 'Tournament succesfully registered';
		break;

		case 2:
			$return = 'Tournament not found!';
		break;

		case 3:
			$return = 'Entry was created successfully';
		break;
	}

	return $return . '<br />';

}



function img($file){
	
	return '<img src="'.GFX_PATH.'/'.$file.'" />';
	
}




?>