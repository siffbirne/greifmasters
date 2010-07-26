<?php
parse_str($_POST['data']);
mysql_connect('localhost', 'root');
mysql_select_db('greifmasters');

var_dump($ajax_list);

for ($i = 0; $i < count($ajax_list); $i++) {
	if(is_int($i)) {
		mysql_query("UPDATE upc_matches SET match_order = '$i' WHERE match_id = '$ajax_list[$i]'");
	}
	else {
	exit;
	}
}
?>