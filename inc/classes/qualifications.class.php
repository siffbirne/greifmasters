<?php

class qualifications extends bracket{
	
	protected $id;
	protected $tournament_id;
	protected $status;
	protected $timelimit_policy;
	protected $start_time;
	protected $end_time;
	protected $bracket_id;
	protected $mode;
	
	protected $court;
	
	protected $match_duration;
	protected $pause;
	protected $calculated_time;
	protected $number_of_matches;
	

	

	public function __construct($tournament_id, $match_duration, $pause){
		
		
		
		#FIXME: not good. constructor should only load its corresponding table. who did this here? ;)

		$this->tournament_id = $tournament_id;
		$this->match_duration = $match_duration;
		$this->pause = $pause;
		
		
	}
	

	

	
	
	
	protected function check_court_occupation($court, $start_time, $end_time){
		
		require 'inc/classes/court.class.php';
		$court = new court();
		if ($court->check_occupation($court, $start_time, $end_time)==FALSE){
			return FALSE;
		}
		return TRUE;
		
		
	}
	
	
	protected function occupie_court($court_id, $start_time, $end_time){
		

		$court = new court();
		$court->load($court_id);
		
		#@todo: court occupation still crap. should be done by the court class
		
		$return = $court->occupie_court($this->bracket_id, $start_time, $end_time);
		
		if ($return == FALSE){
			return 'Problem taking court';
		}
		return $return;
		
		
		return;
		
	}
	
	
	
	protected function save_bracket_to_database($matchlist){
		
	// matches in upc matches...................................................................

		$query="
			INSERT INTO 
				gm_brackets (tournament_id, mode, status, timelimit_policy)
			VALUES
				('$this->tournament_id', '$this->mode', '0', '0')
		";
		
		mysql_query ( $query ) or die ( mysql_error () );
		
		$this->bracket_id = mysql_insert_id();
		
		
		
		foreach($matchlist as $match){
			
			$query = "
				INSERT INTO 
					gm_matches (bracket_id, team1, team2)
				VALUES
					('$this->bracket_id', '$match[0]', '$match[1]')
			";
			
			$result = mysql_query ( $query ) or die ( mysql_error () );
			
			$match_id = mysql_insert_id();
			
			$query="
				INSERT INTO 
					gm_upc_matches (bracket_id, match_id)
				VALUES
					('$this->bracket_id', '$match_id')
			";
			
			mysql_query ( $query ) or die ( mysql_error () );
			
		}
		
		

		
	}
	
}

?>