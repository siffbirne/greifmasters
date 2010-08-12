<?php



class bracket extends db {
	
	#@todo: set-methods: ugly, too many. any better way?
	

	protected $id;
	protected $name;
	protected $tournament_id;
	protected $status;
	protected $start_time;
	protected $end_time;
	protected $mode;
	protected $type;
	protected $timelimit1;
	protected $timelimit2;
	protected $timelimit3;
	protected $timelimit4;
	protected $timelimit5;
	protected $pause1;
	protected $pause2;
	protected $pause3;
	protected $pause4;
	protected $pause5;



	

	public function __construct() {

		parent::__construct ( 'brackets' );
	
	}



	public function setup($name, $type) {

		parent::store ( 'name, type, tournament_id, status', "'$name', '$type', '" . $_SESSION ['tournament_id'] . "', '1'" );
	}



	
	public function get_id() {

		return $this->id;
	}



	public function get_name() {

		return $this->name;
	}



	public function get_type() {

		return $this->type;
	}



	public function get_tournament_id() {

		return $this->tournament_id;
	}



	public function get_status() {

		return $this->status;
	}



	public function get_start_time() {

		return $this->start_time;
	}



	public function get_end_time() {

		return $this->end_time;
	}



	public function get_mode() {

		return $this->mode;
	}



	public function get_timelimit1() {

		return $this->timelimit1;
	}



	public function get_pause1() {

		return $this->pause1;
	}



	public function get_courts() {

		$occupation = new court_occupation ( );
		return $occupation->get_courts_for_bracket ( $this->id );
	}



	public function set_type($type) {

		self::update ( "type='$type'", "id='$this->id'" );
	}



	public function set_timelimit1($value) {

		self::update ( "timelimit1='$value'", "id='$this->id'" );
	}



	public function set_pause1($value) {

		self::update ( "pause1='$value'", "id='$this->id'" );
	}



	public function set_timelimit2($value) {

		self::update ( "timelimit2='$value'", "id='$this->id'" );
	}



	public function set_pause2($value) {

		self::update ( "pause2='$value'", "id='$this->id'" );
	}



	public function set_timelimit3($value) {

		self::update ( "timelimit3='$value'", "id='$this->id'" );
	}



	public function set_pause3($value) {

		self::update ( "pause3='$value'", "id='$this->id'" );
	}



	public function set_timelimit4($value) {

		self::update ( "timelimit4='$value'", "id='$this->id'" );
	}



	public function set_pause4($value) {

		self::update ( "pause4='$value'", "id='$this->id'" );
	}



	public function set_timelimit5($value) {

		self::update ( "timelimit5='$value'", "id='$this->id'" );
	}



	public function set_pause5($value) {

		self::update ( "pause5='$value'", "id='$this->id'" );
	}



	public function set_status($value) {

		self::update ( "status='$value'", "id='$this->id'" );
	}



	public function calculate_time_needed($timelimit, $pause) {

		#@todo: not sure if result is right
		return self::get_number_of_matches () * $pause * $timelimit;
	
	}



	public function get_number_of_matches() {

		return sizeof ( parent::fetch_results ( "SELECT id FROM gm_matches WHERE bracket_id = '$this->id'" ) );
	}



	public function get_number_of_teams() {

		return sizeof ( self::get_qualified_teams () );
	}



	public function get_qualified_teams() {

		$qualified = new bracket_qualification ( $this->id );
		return $qualified->get_qualified_teams ();
	}



	//	protected function store(){
	//				
	//		parent::store('
	//				tournament_id, bracket_name, type, mode, status,
	//				timelimit1, pause1,
	//				timelimit2, pause2,
	//				timelimit3, pause3,
	//				timelimit4, pause4,
	//				timelimit5, pause5
	//			', "
	//				'".$_SESSION['tournament_id']."', '$this->bracket_name', '$this->type', '$this->mode', '0',
	//				'$this->timelimit5', '$this->pause5',
	//				'$this->timelimit4', '$this->pause4',
	//				'$this->timelimit3', '$this->pause3',
	//				'$this->timelimit2', '$this->pause2',
	//				'$this->timelimit1', '$this->pause1'
	//
	//		");
	//
	//	}
	





	public function delete($id) {

		unset ( $_SESSION ['bracket_id'], $_SESSION ['temp'] ['bracket'] );
		

		parent::query ( "
			DELETE FROM
				gm_upc_matches
			WHERE
				match_id IN (SELECT id FROM gm_matches WHERE bracket_id='$id')
		" );
		
		parent::query ( "
			DELETE FROM
				gm_goals
			WHERE
				match_id IN (SELECT id FROM gm_matches WHERE bracket_id='$id')
		" );
		
		parent::query ( "
			DELETE FROM
				gm_fouls
			WHERE
				match_id IN (SELECT id FROM gm_matches WHERE bracket_id='$id')
		" );
		
		parent::query ( "
			DELETE FROM
				gm_matches
			WHERE
				bracket_id='$id'
		" );
		
		parent::query ( "
			DELETE FROM
				gm_bracket_qualifications
			WHERE
				bracket_id='$id'
		" );
		parent::query ( "
			DELETE FROM
				gm_seeding
			WHERE
				bracket_id='$id'
		" );
		
		parent::delete ( $id );
	
	}



	public function seeding() {

		$qualified = new bracket_qualification ( $this->id );
		$teams = $qualified->get_qualified_teams ();

		$db = new db ( 'seeding' );
		
		foreach ( $teams as $team ) {
			$db->query ( "INSERT INTO gm_seeding (team_id, bracket_id) VALUES ('" . $team['id'] . "', '$this->id')" );
		}
	}



	public function get_seeding() {

		$db = new db ( 'seeding' );
		return $db->fetch_results ( "SELECT @rownum:=@rownum+1 nr, s.id, s.team_id, t.name FROM (SELECT @rownum:=0) r, gm_seeding s INNER JOIN gm_teams as t on t.id=s.team_id WHERE s.bracket_id='$this->id' ORDER BY s.value" );
	
	}



	protected function store_matchlist($matchlist) {

		#@todo: set bracket status to sth so the schedule can't be stored more than once due to just reloading the form
		

		$check = new bracket ( );
		$match_order = 0;
		
		$courts = self::get_courts ();
		

		foreach ( $matchlist as $match ) {
			
			$team1 = $match [0];
			$team2 = $match [1];
			$identifier = $match [2];
			
			$new_match = new match ( );
			$new_match->store ( "'$this->id', '$team1', '$team2', '$identifier'" );
			
			$match_id = $new_match->insert_id;
			
			$nextcourt = each ( $courts );
			if ($nextcourt == FALSE) {
				reset ( $courts );
				$nextcourt = each ( $courts );
			}
			$nextcourt = $nextcourt ['value'];
			$court_id = $nextcourt ['id'];
			
			$upc_match = new upc_match ( );
			$upc_match->store ( $match_id, $court_id, $match_order );
			
			$match_order ++;
		}
	
	}



	public function set_qualified_teams($mode, $top_nr = '', $from_bracket = '') {

		switch ($mode) {
			
			case 'select':
				
				return;
			
			case 'top' :
				$bracket = new bracket ( );
				$bracket->load_entry ( $from_bracket );
				$type = $bracket->get_type ();
				$bracket = new $type ( );
				$bracket->load_entry ( $from_bracket );
				$ranking = $bracket->get_ranking ( '', TRUE );
				$qualified = array_slice ( $ranking, 0, $top_nr );
				break;
			
			case 'all' :
				$registration = new registration ( );
				$qualified = $registration->get_registered_teams ( $this->tournament_id );
				break;
		
		}
		
		$bracket_qualification = new bracket_qualification ( $this->id );
		
		foreach ( $qualified as $team ) {
			$bracket_qualification->add ( $team ['id'] );
		}

	}



	public function process_finished_match() {

		return TRUE;
	}

	public function get_top_scorers($limit = FALSE){
		
		$query = "
			SELECT
				p.id, p.name AS player_name, t.name AS team_name,
			(SELECT count(*) FROM gm_goals AS g WHERE g.player_id = p.id AND g.match_id IN (SELECT id FROM gm_matches WHERE bracket_id = '$this->id')) AS goals_scored
			FROM gm_players AS p
			INNER JOIN gm_teams AS t ON t.player1 = p.id OR t.player2 = p.id OR t.player3 = p.id
			ORDER BY goals_scored DESC
		";
		
		if ($limit != FALSE){
			$query .= 'LIMIT '.$limit;
		}
		
		$results = self::fetch_results($query);
		
		echo '<table class="ranking"><tr><th>Rank</th><th>Name</th><th>Team</th><th>Goals scored</th></tr>'."\n";
		$i = 1;
		
		foreach ($results as $row){
			
			if ( !isset($temp) || ($row['goals_scored'] < $temp && $temp > 0)){
				$temp = (int)$row['goals_scored'];
				$count = $i;
			}
				$i++;
			
			echo '<tr><td>'.$count.'</td><td>'.$row['player_name'].'</td><td>'.$row['team_name'].'</td><td>'.$row['goals_scored'].'</td></tr>';
		}
		
		echo '</table>';
		
	}

	public function get_match_results() {

		#@todo: ugly!
		


		echo '<table class="ranking">
			<tr>
				<!--		<th>Court</th>-->
				<th>Team 1</th>
				<th>Team 2</th>
				<th>Score</th>
				<th>Time</th>
		';
		if (AUTHORIZED == TRUE) {
			echo '
				<th>Action</th>
			';
		}
		
		echo '</tr>';
		
		$query = "
		SELECT
			t1.name AS team1,
			t2.name AS team2,
			t1.id AS team1_id,
			t2.id AS team2_id,
			DATE_FORMAT(m.datetime, '%a, %H:%i') AS time,
			m.id AS match_id,
			(
				SELECT
					count(*)
				FROM
					gm_goals
				WHERE
					((team_id = t1.id AND regular = '1')
					OR
					(team_id != t1.id AND regular = '0'))
				AND
					match_id = m.id
			) AS goals1,
			(
				SELECT
					count(*)
				FROM
					gm_goals
				WHERE
					((team_id = t2.id AND regular = '1')
					OR
					(team_id != t2.id AND regular = '0'))
				AND
					match_id = m.id
			) AS goals2
		FROM
			gm_matches AS m
			INNER JOIN gm_teams AS t1 ON t1.id = m.team1
			INNER JOIN gm_teams AS t2 ON t2.id = m.team2
		WHERE m.status = 1
		AND m.bracket_id = '" . $this->id . "'
		ORDER BY datetime DESC
		
	";
		
		$matches = new match ( );
		$matches = $matches->fetch_results ( $query );
		if ($matches == FALSE) {
			echo '<tr><td>no results found</td></tr></table>';
			return;
		}
		
		foreach ( $matches as $match ) {
			
			echo '
		<tr>

			<td>';
			
			if ($match ['goals1'] > $match ['goals2']) {
				echo '<b>' . $match ['team1'] . '</b>';
			} else {
				echo $match ['team1'];
			}
			
			echo '</td><td>';
			
			if ($match ['goals2'] > $match ['goals1']) {
				echo '<b>' . $match ['team2'] . '</b>';
			} else {
				echo $match ['team2'];
			}
			
			echo '
			</td>
			<td>' . $match ['goals1'] . ':' . $match ['goals2'] . '</td>
			<td>' . $match ['time'] . '</td>';
			if (AUTHORIZED == TRUE) {
				echo '
			<td><a href="' . BASE . '/play_tournament/matches/' . $match ['match_id'] . '"><img src="' . GFX_EDIT . '" /></a></td>
			';
			}
			echo '</tr>';
		
		}
		echo '</table>';
	}



	public function generate_schedule($court = FALSE, $additional_processing = FALSE) {

		$query = "
			SELECT
				t1.name AS team1,
				t2.name AS team2,
				m.id AS match_id,
				m.team1 AS team1_id,
				m.team2 AS team2_id,
				u.ready_team1 AS ready_team1,
				u.ready_team2 AS ready_team2,
				u.court_id AS court
			FROM
				gm_upc_matches AS u
				INNER JOIN gm_matches AS m ON m.id = u.match_id
				INNER JOIN gm_teams AS t1 ON m.team1 = t1.id
				INNER JOIN gm_teams AS t2 ON m.team2 = t2.id
			WHERE
				m.bracket_id = '" . $this->id . "'";
		if ($court!=FALSE){
			$query .= " AND u.court_id = '$court'";
		}
		$query .= "
			ORDER BY u.match_order ASC, u.id ASC
		";
		
		#,c.name AS court INNER JOIN courts AS c ON c.id = u.court_id
		

		$offset_count = 0;
		$return_courts = array ();
		$blocks = array ();
		


		$timelimit1 = self::get_timelimit1 ();
		$pause1 = self::get_pause1 ();
		


		$upc_matches = new upc_match ( );
		$upc_matches = $upc_matches->fetch_results ( $query );
		


		$get_courts = self::get_courts ();
		$courts = array ();
		foreach ( $get_courts as $row ) {
			$courts [$row ['id']] ['count'] = 0;
			$courts [$row ['id']] ['name'] = $row['name'];
		}
		


		$tournament = new tournament ( );
		$tournament->load_entry($this->tournament_id);
		$playing_times = $tournament->get_playing_times ();
		
		foreach ( $playing_times as $match_index => $timespan ) {
			if (time () < strtotime ( $timespan ['end'] ) && time () > strtotime ( $timespan ['begin'] )) {
				$start = time ();
				$current_playing_time_index = $match_index;
			} elseif (! isset ( $start ) && time () < strtotime ( $timespan ['begin'] )) {
				$start = strtotime ( $timespan ['begin'] );
				$current_playing_time_index = $match_index;
			}
		}
		




		foreach ( $upc_matches as $match_index => $upc_match ) {
			#@todo: bei verspätungen an einem einzelnen court oder wenn man zu früh im zeitplan ist werden die matches nicht mehr chronologisch angezeigt
			if ($playing_times != FALSE) {
				
				$court_id = $upc_match ['court'];
				
				if (! isset($courts [$court_id])) {
					$court_id = key ( $courts );
				}
				
				$scheduled_time = $start + (($timelimit1 + $pause1) * 60 * $courts [$court_id] ['count']);
				
				if ($scheduled_time + (($timelimit1 + $pause1) * 60) > strtotime ( $playing_times [$current_playing_time_index] ['end'] )) {
					

					if (!isset($playing_times [($current_playing_time_index + 1)])) {
						$scheduled_time = FALSE;
					} else {
						$current_playing_time_index ++;
						$scheduled_time = strtotime ( $playing_times [$current_playing_time_index] ['begin'] );
						
						$start = $scheduled_time;
						foreach ( $courts as $key => $row ) {
							$courts [$key] ['count'] = 0;
						}
						reset ( $courts );
					
					}
				}
			} else {
				$scheduled_time = FALSE;
			}
			


			$return_blocks_courts [$current_playing_time_index] [$court_id] [] = array ('index' => ($match_index + 1), 'id' => $upc_match['match_id'],  'court_index' => $courts [$court_id] ['count'], 'time' => $scheduled_time, 'team1' => $upc_match ['team1'], 'team1_id' => $upc_match ['team1_id'], 'team2' => $upc_match ['team2'], 'team2_id' => $upc_match ['team2_id'] );
			$return_courts [$court_id] [] = array ('index' => ($match_index + 1), 'id' => $upc_match['match_id'], 'court_index' => $courts [$court_id] ['count'], 'time' => $scheduled_time, 'team1' => $upc_match ['team1'], 'team1_id' => $upc_match ['team1_id'], 'team2' => $upc_match ['team2'], 'team2_id' => $upc_match ['team2_id'] );
			$courts [$court_id] ['count'] ++;
			$offset_count ++;
		
		}
		
		#@todo: match-nummer fest, als fixe id
		ksort ( $return_courts );
		

		switch ($additional_processing) {
			case 'pause/next' :
				

				$teams = self::get_qualified_teams();
				
				$matches_per_block = array ();
				

				foreach ( $return_blocks_courts as $block_index => $block ) {
					


					foreach ( $teams as $team ) {
						$matches_per_block [$block_index] [$team ['id']] ['name'] = $team ['name'];
						$matches_per_block [$block_index] [$team ['id']] ['played'] = 0;
					}
					

					foreach ( $block as $court_index => $court ) {
						
						$pause_team1 = FALSE;
						$pause_team2 = FALSE;
						$next_team1 = FALSE;
						$next_team2 = FALSE;
						
						foreach ( $court as $match_index => $match ) {
							

							foreach ( $court as $other_courts_matches ) {
								
								$pause_dummy1 = 0;
								$pause_dummy2 = 0;
								$next_dummy1 = 0;
								$next_dummy2 = 0;
								

								while ( isset ( $other_courts_matches [$match_index - $pause_dummy1 - 1] ) ) {
									
									if ($other_courts_matches [$match_index - $pause_dummy1 - 1] ['team1_id'] == $match ['team1_id'] || $other_courts_matches [$match_index - $pause_dummy1 - 1] ['team2_id'] == $match ['team1_id']) {
										if ($pause_dummy1 < $pause_team1 || $pause_team1 == FALSE) {
											$pause_team1 = $pause_dummy1;
										}
										break;
									}
									$pause_dummy1 ++;
								}
								
								while ( isset ( $court [$match_index - $pause_dummy2 - 1] ) ) {
									
									if ($court [$match_index - $pause_dummy2 - 1] ['team1_id'] == $match ['team2_id'] || $court [$match_index - $pause_dummy2 - 1] ['team2_id'] == $match ['team2_id']) {
										if ($pause_dummy2 < $pause_team2 || $pause_team2 == FALSE) {
											$pause_team2 = $pause_dummy2;
										}
										break;
									}
									$pause_dummy2 ++;
								}
								

								while ( isset ( $court [$match_index + $next_dummy1 + 1] ) ) {
									
									if ($court [$match_index + $next_dummy1 + 1] ['team1_id'] == $match ['team1_id'] || $court [$match_index + $next_dummy1 + 1] ['team2_id'] == $match ['team1_id']) {
										if ($tilnext_dummy1 < $tilnext_team1 || $tilnext_team1 == FALSE) {
											$tilnext_team1 = $next_dummy1;
										}
										break;
									}
									$next_dummy1 ++;
								}
								
								while ( isset ( $court [$match_index + $next_dummy2 + 1] ) ) {
									
									if ($court [$match_index + $next_dummy2 + 1] ['team1_id'] == $match ['team2_id'] || $court [$match_index + $next_dummy2 + 1] ['team2_id'] == $match ['team2_id']) {
										if ($tilnext_dummy2 < $tilnext_team2 || $tilnext_team2 == FALSE) {
											$tilnext_team2 = $next_dummy2;
										}
										break;
									}
									$next_dummy2 ++;
								}
								
								$match ['pause_team1'] = $pause_team1;
								$match ['pause_team2'] = $pause_team2;
								$match ['tilnext_team1'] = $tilnext_team1;
								$match ['tilnext_team2'] = $tilnext_team2;
								
							
							}
							$return_blocks_courts [$block_index] [$court_index] [$match_index] = $match;
							
							$matches_per_block [$block_index] [$match ['team1_id']] ['played'] ++;
							$matches_per_block [$block_index] [$match ['team2_id']] ['played'] ++;
						
						}
					
					}
				
				}
				
				$teams = array ();
				$played = array ();
				foreach ( $matches_per_block as $block_index => $block ) {
					
					foreach ( $block as $key => $row ) {
						$teams [$key] = $row ['name'];
						$played [$key] = $row ['played'];
					}
					array_multisort ( $teams, $played );
					
					$matches_per_block [$block_index] = array ();
					
					foreach ( $teams as $team_index => $team ) {
						$matches_per_block [$block_index] [$team_index] ['name'] = $team ;
						$matches_per_block [$block_index] [$team_index] ['played'] = $played [$team_index];
					}
				
				}
				
				return array ($return_blocks_courts, $matches_per_block );
				
				break;
			
			case FALSE :
				return $return_courts;
				break;
		}
	


	}
}

?>