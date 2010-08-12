<?php
require 'inc/functions.inc.php';

$tournament_id = TOURNAMENT_ID;

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
	$col1_content .= '<a href="'.PAGE_ROOT.'/index.php?bracket='.$bracket['id'].'">'.$bracket['name'].'</a><br />'."\n";
}
$col1_content .= '</div></div>'."\n";

$bracket = new bracket();
$bracket->load_entry($bracket_id);
$type = $bracket->get_type();
$bracket = new $type();
$bracket->load_entry($bracket_id);
ob_start();

if (isset($_GET['rotate'])){

echo '<script language="JavaScript1.2">
var currentpos=0,alt=1,curpos1=0,curpos2=-1
function initialize(){
startit()
}
function scrollwindow(){
if (document.all)
temp=document.body.scrollTop
else
temp=window.pageYOffset
if (alt==0)
alt=1
else
alt=0
if (alt==0)
curpos1=temp
else
curpos2=temp
if (curpos1!=curpos2){
if (document.all)
currentpos=document.body.scrollTop+1
else
currentpos=window.pageYOffset+1
window.scroll(0,currentpos)
}
else{
currentpos=0
window.scroll(0,currentpos)
}
}
function startit(){
setInterval("scrollwindow()",10)
}
window.onload=initialize
</script>';
}

	

echo '<h2>Schedule:</h2>'."\n";
$courts = $bracket->generate_schedule();

	foreach ($courts as $key=>$row){
		
		$court = new court();
		$court->load_entry($key);
		$name = $court->get_name();
		
		echo'<div class="float_50perc"><h3>'.$name.'</h3><br />
			<table class="schedule">
				<tr>
					<th>No.</th>
					<th>Time</th>
					<th>Team 1</th>
					<th>Team 2</th>
				</tr>';
		
		foreach ($row as $row2){
			
			if ($row2['time'] == FALSE){
				$time = 'N/A';
			}else{
				$time = date ( 'D, H:i', $row2['time'] );
			}
			
			echo '<tr><td>'.$row2['index'].'</td><td>'.$time.'</td><td>'.$row2['team1'].'</td><td>'.$row2['team2'].'</td></tr>'."\n";
		}
		
		
		echo '</table></div>';
	}
echo '<br class="clear" />';	
echo '<h2>Current ranking:</h2>'."\n";
$bracket->draw_ranklist();
echo '<h2>All results:</h2>'."\n";
$bracket->get_match_results();
echo '<h2>Top 50 scorers:</h2>'."\n";
$bracket->get_top_scorers(50);



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