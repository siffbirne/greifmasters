<?php
class registration extends db{

	protected $id;
	protected $team_id;
	protected $tournament_id;
	protected $registered_by;


	
	public function __construct(){
		parent::__construct('registration');
	}

	
	
	public function get_id(){
		return $this->id;
	}
	
	public function get_team_id(){
		return $this->team_id;
	}
	
	public function get_tournament_id(){
		return $this->tournament_id;
	}
	
	public function get_registered_by(){
		return $this->registered_by;
	}
	
	
	public function store($team_id, $tournament_id){

		parent::store(
			'team_id, tournament_id, registered_by, registered_date',
			"'$team_id','".$_SESSION['tournament_id']."','".$_SESSION['user']."',NOW()"
		);
		
		$this->id = $this->insert_id;
	

	}

	public function is_registered($team_id, $tournament_id){
		$registered_teams = self::get_registered_teams($tournament_id);
		foreach ($registered_teams as $team){
			if (in_array($team_id, $team)){return TRUE;}
		}
		return FALSE;
	}

	public function get_registered_teams($tournament_id){
		
		$query = "
			SELECT
				t.id, t.name, t.city, r.id AS reg_id
			FROM
				teams AS t
				INNER JOIN registration AS r ON t.id = r.team_id
			WHERE r.tournament_id='$tournament_id'
		";
		
		
		
		return parent::fetch_results($query);
	}


	
	public function set_group_assignment($group){
		parent::update("assignments='".$group."'", "id='".$this->id."'");
	}
}


?>