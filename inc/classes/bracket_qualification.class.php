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
		
		#@todo: return value was changed from array(id) to array (array(id, name)). any trouble?
		
		$query = "SELECT q.team_id, t.name FROM gm_bracket_qualifications AS q INNER JOIN gm_teams AS t ON q.team_id = t.id";
		
		$help = parent::fetch_results($query);
		foreach ($help as $row){
			$return[] = array('id' => $row['team_id'], 'name' => $row['name']);
		}
		return $return;
	}
}

?>