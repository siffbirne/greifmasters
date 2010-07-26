<?php



class bracket_qualification extends db {

	protected $id;
	protected $bracket_id;
	
	public function __construct($bracket_id) {

		parent::__construct ('bracket_qualifications');
		$this->bracket_id = $bracket_id;
		
	}
	
	public function add($team_id){
		parent::store('bracket_id, team_id', "'$this->bracket_id', '$team_id'");
	}
	
	public function get_qualified_teams(){
		
		$help = parent::select('team_id',"bracket_id='$this->bracket_id'");
		foreach ($help as $row){
			$return[] = $row['team_id'];
		}
		return $return;
	}
}

?>