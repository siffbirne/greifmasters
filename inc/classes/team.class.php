<?php

#@todo: some set-methods missing (or not necessary)

class team extends db{
	
	protected $id;
	protected $name;
	protected $city;
//	protected $player1;
//	protected $player2;
//	protected $player3;
	protected $created_by;
	protected $logo;
	
	
	
	public function __construct(){
		parent::__construct('teams');
	}


	
	public function get_id(){
		return $this->id;
	}

	
	public function get_name(){
		return $this->name;
	}
	
	
	public function get_name_by_id($id){
		
		$select = parent::select('name',"id='$id'");
		return $select[0]['name'];
		
	}
	
	public function get_city(){
		return $this->city;
	}
	
	public function get_logo(){
		return $this->logo;
	}
	
	
	public function get_players(){
		
		$query = "
			SELECT
				p1.id AS player1_id,
				p1.name AS player1,
				p2.id AS player2_id,
				p2.name AS player2,
				p3.id AS player3_id,
				p3.name AS player3
			FROM
				gm_teams AS t
				INNER JOIN gm_players AS p1 ON t.player1 = p1.id
				INNER JOIN gm_players AS p2 ON t.player2 = p2.id
				INNER JOIN gm_players AS p3 ON t.player3 = p3.id
			WHERE t.id = '$this->id'
		";
		
		$players = parent::fetch_results($query);
		return $players[0];
		
		#@todo: proper array would be much more sensible. array(array(), array(), array())
	
		
	}
	
	public function get_brackets($tournament = ''){
		$query = "
			SELECT
				b.id, b.name
			FROM
				gm_brackets AS b
				INNER JOIN gm_tournaments AS t ON t.id = b.tournament_id
				INNER JOIN gm_bracket_qualifications AS q ON q.bracket_id = b.id
			WHERE q.team_id = '$this->id'
		";
		if ($tournament != ''){
			$query .= " AND t.id = '$tournament'";
		}
		return self::fetch_results($query);
	}
	
	public function get_matches($bracket = '', $tournament = ''){
			$query = "
			SELECT
				t1.name AS team1,
				t2.name AS team2,
				t1.id AS team1_id,
				t2.id AS team2_id,
				DATE_FORMAT(m.datetime, '%a, %H:%i') AS time,
				m.id AS match_id,
				m.bracket_id AS bracket_id,
				b.name AS bracket_name,
				t.id AS tournament_id,
				m.status AS status,
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
				INNER JOIN gm_brackets AS b ON b.id = m.bracket_id
				INNER JOIN gm_tournaments AS t ON t.id = b.tournament_id
			WHERE (t1.id = '" . $this->id . "' OR t2.id = '" . $this->id . "')			
			";
			
			if ($bracket != ''){
				$query .= " AND bracket_id = '$bracket'";
			}elseif($tournament != ''){
				$query .= " AND tournament_id = '$tournament'";
			}
			$query .= '	ORDER BY datetime DESC';

			return self::fetch_results($query);
	}
	
	public function get_goals($bracket = '', $tournament = ''){
		
		$query = "
			SELECT
				g.id AS goal_id,
				g.player_id AS player_id,
				p.name AS player_name,
				g.match_id AS match_id,
				teams.name AS opponent				
			FROM gm_goals AS g
			LEFT JOIN gm_players AS p ON p.id = g.player_id
			INNER JOIN gm_matches AS m ON m.id = g.match_id
			INNER JOIN gm_teams AS teams ON (teams.id = m.team1 OR teams.id = m.team2) AND teams.id != '" . $this->id . "'
			INNER JOIN gm_brackets AS b ON m.bracket_id = b.id
			INNER JOIN gm_tournaments AS t ON t.id = b.tournament_id
			WHERE g.team_id = '" . $this->id . "'
		";
		
		if ($bracket != ''){
				$query .= " AND m.bracket_id = '$bracket'";
			}elseif($tournament != ''){
				$query .= " AND b.tournament_id = '$tournament'";
			}
		
		return self::fetch_results($query);
		
	}

	public function store($team_name, $city, $player1, $player2, $player3, $logo='') {

	
		
		$players = array();

			foreach ( array($player1, $player2, $player3) as $name ) {
				$player = new player();
				
				$player->store($name, '', '', '', '');
				$players[] = $player->get_id();
		}
		
		parent::store(
			'name, city, player1, player2, player3, logo, created_by',
				"'$team_name',
				'$city',
				'" . $players[0] . "',
				'" . $players[1] . "',
				'" . $players[2] . "',
				'$logo',
				'".$_SESSION['user']."'"
		);
			

		
		
		
		
	
	}



	public function load_entry($id) {

		$query = "
			SELECT

				t.name AS name,
				t.city AS city,
				t.player1 AS player1,
				t.player2 AS player2,
				t.player3 AS player3,
				t.logo AS logo,
				t.created_by

			FROM
				gm_teams AS t
			INNER JOIN gm_players AS p1 ON t.player1 = p1.id
			INNER JOIN gm_players AS p2 ON t.player2 = p2.id
			INNER JOIN gm_players AS p3 ON t.player3 = p3.id
			WHERE t.id = '$id'
			AND p1.id != p2.id
			AND p1.id != p3.id
			AND p2.id != p3.id
		";
		
		try {$result = parent::query ( $query );}
		catch ( Exception $exception ) {
				echo 'Error: ' . $exception->getMessage () . '<br />';
				echo 'File: ' . $exception->getFile () . '<br />';
				echo 'Line: ' . $exception->getLine () . '<br />';
			}
			
		$data = $result->fetch_assoc();
		
		$this->id = $id;
		$this->name = $data ['name'];
		$this->city = $data ['city'];
		$this->player1 = $data ['player1'];
		$this->player2 = $data ['player2'];
		$this->player3 = $data ['player3'];
		$this->logo = $data ['logo'];
		$this->created_by = $data['created_by'];
		
		
		$result->close ();
		
		
		
	}
	
	
	
	public function set_players($player1, $player2, $player3){
		parent::update('player1=`'.$player1.'`, player2=`'.$player2.'`, player3=`'.$player3.'`', 'id=`'.$this->id.'`');
	}
	


}

?>