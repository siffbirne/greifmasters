<?php


class goal extends game_event {

	protected $regular;
	

	public function __construct() {

		parent::__construct ('goals');
	
	}
	
	public function get_regular(){
		return $this->regular;
	}
	
	public function store($team, $player, $match, $minute, $regular){
		db::store('team_id, player_id, match_id, g_minute, regular', "'$team', '$player', '$match', '$minute', '$regular'");
	}
	
	public function get_match_goals($id, $team){
		
		$query="
			SELECT
				g.id AS id,
				p.id AS player_id,
				p.name AS player,
				g.g_minute AS g_minute,
				g.regular AS regular,
				t.id AS team_id,
				t.name AS team_name
			FROM
				gm_goals AS g
				INNER JOIN gm_matches AS m ON m.id = g.match_id
				INNER JOIN gm_teams AS t ON t.id = g.team_id
				INNER JOIN gm_players AS p ON p.id = g.player_id
			WHERE
				g.match_id = '$id'
				AND
				((g.team_id = '$team' AND g.regular='1') OR (g.team_id != '$team' AND g.regular='0'))
		";

		$result = db::fetch_results($query);
		
		$goals = array();
		if ($result == FALSE){
			$goals = array('goals' => FALSE, 'count' => 0);
		}else{
			#@todo: this makes no sense. calling sizeof later instead does
			$goals ['goals'] = $result;
			$goals ['count'] = sizeof($result);
		}
		
		return $goals;
	}
}

?>