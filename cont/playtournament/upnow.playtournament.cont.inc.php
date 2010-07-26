<?php


#@FIXME: clear url to standard after get-triggered actions to enable reload-ability

if (isset ( $_GET ['p3'] ) && $_GET ['p3'] == 'goal') {
	unset($_GET ['p3']);
	
	if (isset($_GET['p4']) && $_GET['p4'] == 'store'){
		unset($_GET ['p4']);
	
		$team = $_POST ['team'];
		$player = $_POST ['player'];
		$match = $_SESSION ['match_id'];
		$minute = 0;
		if (isset ( $_POST ['owngoal'] )) {
			$regular = 0;
		} else {
			$regular = 1;
		}
		
		$goal = new goal ( );
		$goal->store ( $team, $player, $match, $minute, $regular );

		
	}
	
	if (isset($_GET['p4']) && $_GET['p4'] == 'delete'){
		$goal = new goal();
		$goal->delete($_GET['p5']);
		unset($_GET ['p5']);
		
	}


}



if (isset ( $_GET ['p3'] ) && $_GET ['p3'] == 'finish_match'){
	$match = new match();
	$match->load_entry($_SESSION['match_id']);
	$match->finish();
	
	unset ($_SESSION['match_id']);
	unset($_GET ['p3']);
}



//if (!isset ($_SESSION['match_id'])){

	
	$next_match = new upc_match ( );
	
	$query = "
		SELECT
			u.id,
			m.id AS match_id,
			t1.name AS team1,
			t2.name AS team2,
			m.team1 AS team1_id,
			m.team2 AS team2_id
		FROM
			upc_matches AS u
			INNER JOIN matches AS m ON m.id = u.match_id
			INNER JOIN teams AS t1 ON m.team1 = t1.id
			INNER JOIN teams AS t2 ON m.team2 = t2.id
		WHERE
			m.bracket_id = '".$_SESSION['bracket_id']."'
		ORDER BY u.match_order ASC, u.id ASC
		LIMIT 1
	";
	
	$data = $next_match->fetch_results ( $query );
	$data = $data [0];
	
	if ($data == FALSE){echo 'No scheduled matches'; return;}
	$_SESSION['match_id'] = $data['match_id'];
	unset ($data);
//}

$active = new match ( );
$active->load_entry ( $_SESSION['match_id'] );
$active->set_datetime();


$team1 = new team ( );
$team1->load_entry ( $active->get_team1() );

$team2 = new team ( );
$team2->load_entry ( $active->get_team2() );

$goals1 = $active->get_goals_1 ();
$goals2 = $active->get_goals_2 ();

?>



<div id="controls" class="play_tournament_controls">
		<form action="">
		<div>
			
			<input name="hr" type="hidden" id="hr" value="0" size="2" maxlength="2" />
			min: <input name="min" type="text" id="min" value="8" size="2" maxlength="2" />
			&nbsp; sec: <input name="sec" type="text" id="sec" value="0" size="2" maxlength="2" />			
			
			<input class="button" name="reset" type="button" id="reset" value="Reset" onclick="ResetTimer();"/>

			<input class="button" name="start" type="button" id="start" value="Start" onclick="StartTimer();" />
			<input class="button" name="stop" type="button" id="stop" value="Stop" onclick="StopTimer();" />
			<input class="button" name="continue" type="button" id="continue" value="Continue" onclick="ContinueTimer();" />
			<a href="<?php echo BASE; ?>/play_tournament/matches/ong/finish_match/<?php echo $_SESSION['match_id']; ?>">finish match</a>
		</div>
		</form>

		







	</div>


<div id="main_display" class="play_tournament_controls">


		<table class="play_tournament_team1 play_tournament_team">
			<tr>
				<td><img src="<?php echo TEAM_LOGOS_PATH.'/'.$team1->get_logo();?>" /></td>
				<td class="team_name"><?php echo $team1->get_name();?></td>
			</tr>

		</table>
		
		<table class="play_tournament_team2 play_tournament_team">
			<tr>
				<td class="team_name"><?php echo $team2->get_name();?></td>
				<td><img src="<?php echo TEAM_LOGOS_PATH.'/'.$team2->get_logo();?>" /></td>
			</tr>

		</table>
		
		

	<div id="timeandscore">
		<div class="anzeige" id="Anzeige">08:00</div>
	
		<?php
		echo $goals1 ['count'] . ' - ' . $goals2 ['count'];
		?>
	</div>
	

	
</div>




<div class="play_tournament_team1 play_tournament_team">

	<table>
		<tr>
			<td>
				<?php

				$team = $team1->get_id();
				$players = $team1->get_players ();
			
			
				include 'inc/forms/goals.form.inc.php';
			
				?>
			</td>
			<td style="padding-left: 20px;">
				<?php
					$goals = $goals1['goals'];
					include 'inc/lists/goals.list.inc.php';
				?>
			</td>
		</tr>
	</table>


</div>



<div class="play_tournament_team2 play_tournament_team">

	
		
		<table>
		<tr>
			<td style="padding-right: 20px;">
				<?php
					$goals = $goals2['goals'];
					include 'inc/lists/goals.list.inc.php';
				?>
			</td>
			<td>
				<?php

				$team = $team2->get_id();
				$players = $team2->get_players ();
				include 'inc/forms/goals.form.inc.php';
			
				?>
			</td>

		</tr>
	</table>
	
	
</div>






<div id="upcgames"  class="play_tournament_controls">

	<?php
	include 'cont/inc/tables/upc_matches.table.inc.php';
	?>
	
</div>
