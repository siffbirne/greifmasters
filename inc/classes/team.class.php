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