<?php
parse_str($_POST['data']);
mysql_connect('localhost', 'root');
mysql_select_db('greifmasters');

for ($offset_count = 0; $offset_count < count($ajax_list); $offset_count++) {
	if(is_int($offset_count)) {
		$query = "UPDATE gm_seeding SET value = '$offset_count' WHERE id = '$ajax_list[$offset_count]'";
		mysql_query($query);
		#zu updaten: team_id
	}
	else {
	exit;
	}
}
?>