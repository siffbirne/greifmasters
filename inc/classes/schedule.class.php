<?php

class schedule {
	
	protected $courts;
	protected $bracket_id;
	protected $filter;
	protected $action;
	
	public function __construct($bracket_id){
		$this->bracket_id = $bracket_id;
	}
	
	
	public function generate_schedule(){
		
		$query = "
			SELECT
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
				m.bracket_id = '" . $this->bracket_id . "'
			ORDER BY u.match_order ASC, u.id ASC
		";
		
		#,c.name AS court INNER JOIN courts AS c ON c.id = u.court_id
		
		$offset_count = 0;
		$return = array();
		
		
	
		$bracket = new bracket ( );
		$bracket->load_entry ( $this->bracket_id );
		$timelimit1 = $bracket->get_timelimit1 ();
		$pause1 = $bracket->get_pause1 ();
		
		
		
		$upc_matches = new upc_match ( );
		$upc_matches = $upc_matches->fetch_results ( $query );
		
		
		
		$get_courts = $bracket->get_courts ();
		$courts = array ();
		foreach ( $get_courts as $row ) {
			$courts [$row ['id']] ['count'] = 0;
		}
		
		
	
		$tournament = new tournament ( );
		$tournament->load_entry($_SESSION['tournament_id']);
		$playing_times = $tournament->get_playing_times ();
		
		foreach ( $playing_times as $index => $timespan ) {
			if (time () < strtotime ( $timespan ['end'] ) && time () > strtotime ( $timespan ['begin'] )) {
				$start = time ();
				$current_playing_time_index = $index;
			} elseif (! isset ( $start ) && time () < strtotime ( $timespan ['begin'] )) {
				$start = strtotime ( $timespan ['begin'] );
				$current_playing_time_index = $index;
			}
		}
		
		
		
		
		
		foreach ( $upc_matches as $index => $upc_match ) {
			#@todo: bei verspätungen an einem einzelnen court oder wenn man zu früh im zeitplan ist werden die matches nicht mehr chronologisch angezeigt
			if ($playing_times != FALSE) {
				
				$court_id = $upc_match ['court'];
				
				if (! $courts [$court_id]) {
					$court_id = key($courts);
				}
				
				$scheduled_time = $start + (($timelimit1 + $pause1) * 60 * $courts [$court_id]['count']);
				
				if ($scheduled_time + (($timelimit1 + $pause1) * 60) > strtotime ( $playing_times [$current_playing_time_index] ['end'] )) {
					
					$current_playing_time_index ++;
					if ($playing_times [$current_playing_time_index] == NULL) {
						$scheduled_time = FALSE;
					} else {
						$scheduled_time = strtotime ( $playing_times [$current_playing_time_index] ['begin'] );

						$start = $scheduled_time;
						foreach ( $courts as $key=>$row ) {
							$courts[$key]['count'] = 0;
						}
						
					}
				}
			} else {
				$scheduled_time = FALSE;
			}
			
			
			$courts [$court_id] ['count'] ++;
			
			$return[($index + 1)] = array ('time' => $scheduled_time, 'court' => $court_id, 'team1' => $upc_match['team1'], 'team2' => $upc_match['team2']);
			$offset_count ++;
		
		}
		
		
		
		return $return;
	
	}
	

	
}

?>