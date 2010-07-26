<?php

#@todo: not used at the moment, i think. should be part of class "court". courts should be taken for the complete duration of a tournament and should be selected when creating the tournament

class court_occupation extends db {
	
	
	protected $id;
	protected $court_id;
	protected $bracket_id;
	protected $start_time;
	protected $end_time;
	protected $taken_by;
	



	function __construct() {
		parent::__construct('court_occupation');
	}
	
	
	public function get_id(){
		return $this->id;
	}
	
	public function get_court_id(){
		return $this->court_id;
	}
	
	public function get_bracket_id(){
		return $this->bracket_id;
	}
	
	public function get_start_time(){
		return $this->start_time;
	}
	
	public function get_end_time(){
		return $this->end_time;
	}
	
	public function get_taken_by(){
		return $this->taken_by;
	}
	
	public function get_courts_for_bracket($bracket){
		#@FIXME:  WHERE o.bracket_id='$bracket'
		return self::fetch_results("SELECT c.id, c.name FROM courts AS c INNER JOIN court_occupation AS o ON c.id = o.court_id");
	}
	
	
	
//	public function store($court_id, $bracket_id, $start_time, $end_time){
//		
//		#@todo: check if court is occupied?
//		
//		parent::store(
//			'court_id, bracket_id, start_time, end_time, taken_by',
//			"'$court_id', '$bracket_id', '$start_time', '$end_time','".$_SESSION['user']."'"
//		);
//		
//		
//	}

	public function store($court_id){
		
		#@todo: check if court is occupied?
		
		parent::store(
			'court_id, bracket_id, taken_by',
			"'$court_id', '".$_SESSION['bracket_id']."', '".$_SESSION['user']."'"
		);
		
		
	}
}

?>