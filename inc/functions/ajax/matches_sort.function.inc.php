<?php

#@todo: deprecated

parse_str($_POST['data']);

#require_once ('../../functions.inc.php');
$db = new db('upc_matches');

for ($offset_count = 0; $offset_count < count($ajax_list); $offset_count++) {
	if(is_int($offset_count)) {
		$db->update("match_order = '$offset_count'", "match_id = '$ajax_list[$offset_count]'");
	}
	else {
	exit;
	}
}
?>