<div id="navBoxesContainer">

	
	<div class="navBox">
		

		<?php
		
		if (isset($_SESSION['bracket_id'])){
			
			$bracket = new bracket();
			$bracket->load_entry($_SESSION['bracket_id']);	
			
			echo '<div class="navHeading">current bracket: ' . $bracket->get_name().'</div>';

			
			echo
				'<p><a href="'.BASE.'/play_tournament/brackets/'.$_SESSION['bracket_id'].'">Ranking</a><br />
				<a href="'.BASE.'/play_tournament/brackets/'.$_SESSION['bracket_id'].'/delete">delete bracket</a></p>
				<p><a href="'.BASE.'/play_tournament/matches/upc">schedule</a><br />
				<a href="'.BASE.'/play_tournament/matches/fin">finished matches</a><br />
				</p>
				<p>
				<a href="'.BASE.'/play_tournament/matches/ong">now playing</a>
				</p>
				<p>
				<a href="'.BASE.'/play_tournament/brackets/'.$_SESSION['bracket_id'].'/settings">Bracket settings</a>
				</p>
				<p>
				<!--<a href="#" onclick=\'window.open("/greifmasters/cont/playtournament/display_output/display_output_800x600.php?b='.$_SESSION['bracket_id'].'","GREIFMASTERS 2010","width=800, height=600, status=no, scrollbars=no, resizable=no")\'>display output</a>-->
				<div id="display_output">display output</div>
				</p>
				</div>';
		}

		?>
	
	<div class="navBox">	
		<div class="navHeading">Brackets</div>
		
		<?php
		
			$tournament = new tournament();
			$tournament->load_entry($_SESSION['tournament_id']);
			$brackets = $tournament->get_brackets();
			
			if ($brackets != NULL){
				foreach ($brackets as $row){
					if ($row['id'] != $_SESSION['bracket_id']){
						echo '<a href="'.BASE.'/play_tournament/brackets/'.$row['id'].'">'.$row['name'].'</a><br />';
					}	
				}
			}

			echo '<br /><i><a href="'.BASE.'/play_tournament/brackets/new/start">new bracket</a></i>';
		
		
		?>
	</div>
	
	
	<div class="navBox">
		<div class="navHeading"><a href="<?php echo BASE; ?>">back to start menu</a></div>
	</div>
	
</div>
