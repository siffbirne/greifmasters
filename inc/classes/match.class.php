<?php


class match extends db {

	
	protected $id;
	protected $bracket_id;
	protected $team1;
	protected $team2;
	protected $datetime;
	protected $identifier;
	protected $status;


	public function __construct($table = 'matches') {

		parent::__construct ($table);
	
	}

	
	public function get_id(){
		return $this->id;
	}
	
	public function get_bracket_id(){
		return $this->bracket_id;
	}
	
	public function get_team1(){
		return $this->team1;
	}
	
	public function get_team2(){
		return $this->team2;
	}
	
	public function get_goals_1(){
		$goals = new goal();
		return $goals->get_match_goals($this->id, self::get_team1());
	}
	
	public function get_goals_2(){
		$goals = new goal();
		return $goals->get_match_goals($this->id, self::get_team2());
	}	
	
	public function get_datetime(){
		return $this->datetime;
	}
	
	public function get_identifier(){
		return $this->identifier;
	}
	
	#@todo: set-methods complete?
	
	public function get_status(){
		
		return $this->status;
	}
	
	public function get_winner(){
		#returns team_id of match winner, 0 for a draw, -1 if match is not finished yet
		
		if ($this->status != 1){return -1;}
		
		
		$goals1 = self::get_goals_1();
		$goals2 = self::get_goals_2();
		
		if ($goals1['count']>$goals2['count']){
			return $this->team1;
		}elseif ($goals1['count']==$goals2['count']){
			return 0;
		}if ($goals1['count']<$goals2['count']){
			return $this->team2;
		}
	}
	
	public function set_status($status){
		
		parent::update("status='$status'", "id='$this->id'");
	}
	
	public function set_datetime(){
		parent::update("datetime=NOW()", "id='$this->id'");
	}
	
	public function set_team1($team){
		parent::update("team1='$team'", "id='$this->id'");
	}
	
	public function set_team2($team){
		parent::update("team2='$team'", "id='$this->id'");
	}
	
	public function store($match){
		
		parent::store('bracket_id, team1, team2, identifier', $match);
		
	}
	
	public function delete_match(){
		
		parent::query("
			DELETE FROM
				gm_upc_matches
			WHERE
				match_id='$this->id'
		");
		
		parent::query("
			DELETE FROM
				gm_goals
			WHERE
				match_id = '$this->id'
		");
		
		parent::query("
			DELETE FROM
				gm_fouls
			WHERE
				match_id = '$this->id'
		");
		
		parent::delete($this->id);
		
	}
	
	public function reschedule(){
		self::set_status(0);
		$upc_match = new upc_match();
		$upc_match->store($this->id);
	}
	
	public function finish(){
		
		self::set_status(1);
		
		$bracket = new bracket();
		$bracket->load_entry($this->bracket_id);
		$type = $bracket->get_type();
		
		$bracket = new $type();
		$bracket->load_entry($this->bracket_id);
		
		$bracket->process_finished_match($this->id);
		
		$upc_match = new upc_match();
		$id = $upc_match->select('id',"match_id='$this->id'");
		$id = $id[0]['id'];
		$upc_match->delete($id);
		
		
	}
}

?>