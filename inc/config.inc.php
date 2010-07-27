<?php

#include 'db.inc.php';

define ('BASE', '/greifmasters/admin');
define ('PAGE_ROOT', '/greifmasters');
define ('SELF', $_SERVER['REQUEST_URI']);

//$query = ("SELECT * FROM settings");
//$result = mysql_query($query);
//$settings = mysql_fetch_assoc($result);
//
//unset($query, $result);

// database stuff

define ('DB_HOST', 'localhost');
define ('DB_USER', 'root');
define ('DB_PASS', '');
define ('DB_NAME', 'greifmasters');
define ('DB_TABLE_PREFIX', 'gm_');

define ('AUTHORIZED', FALSE);

if (isset($_SESSION['user'])){
	define ('USER', $_SESSION['user']);
	define ('AUTHORIZED', TRUE);
}


// date and time settings

//define ('LOCAL_DATE_FORMAT',$settings['local_date_format']);
//define ('LOCAL_TIME_FORMAT',$settings['local_time_format']);
//define ('DATE_SEPERATOR',$settings['date_seperator']);


// include paths

define ('TPL_INCLUDE_PATH', 'inc/tpl/');



// grafics

define ('GFX_PATH', PAGE_ROOT.'/gfx');

define ('TEAM_LOGOS_PATH', GFX_PATH.'/team_logos');


define ('GFX_EDIT', GFX_PATH.'/edit.gif');
define ('GFX_DELETE', GFX_PATH.'/delete.gif');
define ('GFX_VIEW', GFX_PATH.'/view.gif');
define ('GFX_ARROW_1', GFX_PATH.'/arrow_1.png');


// directories

define ('DIR_BRACKETING', 'inc/bracketing');

?>