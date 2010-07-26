<?php


parse_str($_POST['data']);

var_dump($ajax_list);


foreach ($ajax_list as $row) {
	$goal = new goal();
	$goal->store($row['player'],$row['match'],$row['minute'],$row['regular']);
	$i++;
}

?>