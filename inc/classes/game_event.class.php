<?php



class game_event extends db {

	protected $id;
	protected $player_id;
	protected $match_id;
	protected $minute;

	
	
	function __construct($table='') {
		parent::__construct($table);
	}
	
	
//	protected function store($query){
//		parent::store($query);
//	}
	
	protected function get_id(){
		return $this->id;
	}
	
	protected function get_player_id(){
		return $this->player_id;
	}
	
	protected function get_match_id(){
		return $this->match_id;
	}
	
	protected function get_minute(){
		return $this->minute;
	}
	
	
	#@todo: set-methoden?
}

?>