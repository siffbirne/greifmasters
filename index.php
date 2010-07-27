<?php
require 'inc/functions.inc.php';

$tournament_id = strip_tags(htmlentities($_GET['tournament_id']));

$tournament = new tournament();
$tournament->load_entry($tournament_id);
$brackets = $tournament->get_brackets();

if (isset ($_GET['bracket'])){
	$bracket_id = strip_tags(htmlentities($_GET['bracket']));
}else{
	$bracket_id = $brackets[0]['id'];	
}

$col1_content = '
	<div class="navBox">	
	<div class="navHeading">Tournament</div>
	<div class="navContent">';
$col1_content .= $tournament->get_name() . ', '. $tournament->get_city() . '<br />' .
$tournament->get_begin(TRUE) . ' - ' . $tournament->get_end(TRUE);
$col1_content.='
	</div></div>
	<div class="navBox">	
	<div class="navHeading">Brackets</div>
	<div class="navContent">
';
foreach ($brackets as $bracket){
	$col1_content .= '<a href="'.PAGE_ROOT.'/index.php?tournament_id='.$tournament_id.'&bracket='.$bracket['id'].'">'.$bracket['name'].'</a><br />';
}
$col1_content .= '</div></div>';

$bracket = new bracket();
$bracket->load_entry($bracket_id);
$type = $bracket->get_type();
$bracket = new $type();
$bracket->load_entry($bracket_id);
ob_start();
echo '<p>Current ranking:</p>';
$bracket->draw_ranklist();
echo '<br /><p>All results</p>';
$bracket->get_match_results();
$main_content = ob_get_contents();
ob_end_clean();



	$page_title = 'Greifmasters Tournament Management';

//	ob_start();
//	include (TPL_INCLUDE_PATH . '/play_tournament.navigation.tpl.php');
//	$col1_content = ob_get_contents();
//	ob_end_clean();
	
	$col2_content = $main_content;
	$page_footer = 'Greifmasters Tournament Management v0.2, &copy; 2010 Max Thomas';
	
	include 'inc/tpl/standard.tpl.php';

?>