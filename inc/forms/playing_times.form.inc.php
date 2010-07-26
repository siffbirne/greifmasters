<?php

if(isset($_POST['submit'])){
	
	$playing_time = new db('playing_times');
	$data = array();
	$buffer= array();
	
	foreach ($_POST as $key=>$value){
		$keys = explode('_', $key);
		$data[$keys[0]][$keys[1]][$keys[3]] = $value;
	}
	unset ($data['submit']);	
	
	
	foreach ($data as $key=>$value){
		if (isset($value['delete'])){
			$playing_time->delete($key);
		}else{
			$playing_time->update(
				"begin='".$value['begin']['year']."-".$value['begin']['month']."-".$value['begin']['day']." ".$value['begin']['hours'].":".$value['begin']['minutes'].":00',
				end='".$value['end']['year']."-".$value['end']['month']."-".$value['end']['day']." ".$value['end']['hours'].":".$value['end']['minutes'].":00'",
				"id='$key'"
			);
		}
	}
	
	if (isset($data['new'])){
		$value = $data['new'];
		$playing_time->store(
			'tournament_id, begin, end',
			"
				'".$_SESSION['tournament_id']."',
				'".$value['begin']['year']."-".$value['begin']['month']."-".$value['begin']['day']." ".$value['begin']['hours'].":".$value['begin']['minutes'].":00',
				'".$value['end']['year']."-".$value['end']['month']."-".$value['end']['day']." ".$value['end']['hours'].":".$value['end']['minutes'].":00'
			"
		);
	}
}


$tournament = new tournament();
$tournament->load_entry($_SESSION['tournament_id']);

echo '<form name="update" action="'.BASE.'/tournament/'.$_SESSION['tournament_id'].'/playing_times" method="post">';

foreach($tournament->get_playing_times() as $row){
	
	echo '<p><input type="checkbox" name="'.$row['id'].'_delete" value="1" />';
	
	
	$strtotime = strtotime($row['begin']);
	$block = new date_dropdown_element($row['id'].'_begin_select_day', 'wday', date('d', $strtotime));
	$month = new date_dropdown_element($row['id'].'_begin_select_month', 'mon', date('m', $strtotime));
	$year = new date_dropdown_element($row['id'].'_begin_select_year', 'year', date('Y', $strtotime));
	$hours = new time_dropdown_element($row['id'].'_begin_select_hours', 'h', date('H', $strtotime));
	$minutes = new time_dropdown_element($row['id'].'_begin_select_minutes', 'm', date('i', $strtotime));
	
	echo $block->output().'.'.$month->output().'.'.$year->output().' '.$hours->output().':'.$minutes->output().'h';

	
	$strtotime = strtotime($row['end']);
	$block = new date_dropdown_element($row['id'].'_end_select_day', 'wday', date('d', $strtotime));
	$month = new date_dropdown_element($row['id'].'_end_select_month', 'mon', date('m', $strtotime));
	$year = new date_dropdown_element($row['id'].'_end_select_year', 'year', date('Y', $strtotime));
	$hours = new time_dropdown_element($row['id'].'_end_select_hours', 'h', date('H', $strtotime));
	$minutes = new time_dropdown_element($row['id'].'_end_select_minutes', 'm', date('i', $strtotime));
	
	echo ' - '.$block->output().'.'.$month->output().'.'.$year->output().' '.$hours->output().':'.$minutes->output().'h</p>';
}


if( isset ($_GET ['p3']) && $_GET ['p3'] == 'add') {
	
	$block = new date_dropdown_element('new_begin_select_day', 'wday');
	$month = new date_dropdown_element('new_begin_select_month', 'mon');
	$year = new date_dropdown_element('new_begin_select_year', 'year');
	$hours = new time_dropdown_element('new_begin_select_hours', 'h');
	$minutes = new time_dropdown_element('new_begin_select_minutes', 'm');
	
	echo '<p>add: '.$block->output().'.'.$month->output().'.'.$year->output().' '.$hours->output().':'.$minutes->output().'h';
	
	
	
	$block = new date_dropdown_element('new_end_select_day', 'wday');
	$month = new date_dropdown_element('new_end_select_month', 'mon');
	$year = new date_dropdown_element('new_end_select_year', 'year');
	$hours = new time_dropdown_element('new_end_select_hours', 'h');
	$minutes = new time_dropdown_element('new_end_select_minutes', 'm');
	
	echo ' -  '.$block->output().'.'.$month->output().'.'.$year->output().' '.$hours->output().':'.$minutes->output().'h</p>';
}


echo '<br /><br /><a href="'.BASE.'/tournament/'.$_SESSION['tournament_id'].'/playing_times/add">add one more block</a> &nbsp;';
echo '<input type="submit" name="submit" value="Save changes" /></form>';


?>

