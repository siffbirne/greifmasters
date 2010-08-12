<div id="navBoxesContainer">

	

	
	<div class="navBox">	
		<div class="navHeading">Brackets</div>
		<div class="navContent">
		<?php
		
//									<!--<a href="#" onclick=\'window.open("/greifmasters/cont/playtournament/display_output/display_output_800x600.php?b='.$_SESSION['bracket_id'].'","GREIFMASTERS 2010","width=800, height=600, status=no, scrollbars=no, resizable=no")\'>display output</a>-->
//							<!--<div id="display_output">display output</div>-->
		
			$tournament = new tournament();
			$tournament->load_entry($_SESSION['tournament_id']);
			$brackets = $tournament->get_brackets();
			
			if ($brackets != NULL){
				foreach ($brackets as $row){
					if (isset($_SESSION['bracket_id']) && $row['id'] == $_SESSION['bracket_id']){

						
						
						echo '<div class="navCurrentBracket"><img src="' .GFX_ARROW_1.'" /> ' . $row['name'].'<br />';
			
						
						echo '
							<div class="padding_5">
							<a href="'.BASE.'/play_tournament/brackets/'.$_SESSION['bracket_id'].'">Ranking</a>
							<p><a href="'.BASE.'/play_tournament/matches/upc">schedule</a><br />';
						
							if (isset($_SESSION['user'])){
								
								echo 'now playing:<br /><ul class="margin_left">';
								
								$bracket = new bracket();
								$bracket -> load_entry($row['id']);
								$courts = $bracket->get_courts();
								
								foreach ($courts as $court){
									echo '<li><a href="'.BASE.'/play_tournament/matches/ong/'.$court['id'].'">'.$court['name'].'</a></li>'."\n";
								}
								
								echo '</ul>';
								
							}
						
						echo '
							<a href="'.BASE.'/play_tournament/matches/fin">finished matches</a><br />
							<a href="'.BASE.'/play_tournament/brackets/'.$_SESSION['bracket_id'].'/stats">statistics</a><br />
							</p>';
						
							if (isset($_SESSION['user'])){
								echo '
									<p>
								<a href="'.BASE.'/play_tournament/brackets/'.$_SESSION['bracket_id'].'/settings">Bracket settings</a><br />
								<a href="'.PAGE_ROOT.'/index.php?bracket='.$_SESSION['bracket_id'].'&rotate=1" target="_BLANK">Display output for players</a><br />
								<a href="'.BASE.'/play_tournament/brackets/'.$_SESSION['bracket_id'].'/prints">Prints</a><br />
								<a href="'.BASE.'/play_tournament/brackets/'.$_SESSION['bracket_id'].'/delete">delete bracket</a>
								</p>';
							}
							
						echo '</div></div>';
					}else{
						echo '<a href="'.BASE.'/play_tournament/brackets/'.$row['id'].'">'.$row['name'].'</a><br />';
					}	
				}
			}

			if (isset($_SESSION['user'])){
				echo '<br /><i><a href="'.BASE.'/play_tournament/brackets/new/start">new bracket</a></i><br />
				<a href="'.BASE.'">back to start menu</a><br />
				<a href="'.BASE.'/logout">logout</a>';
			}
		
		
		?>
		</div>
	</div>
	
</div>
