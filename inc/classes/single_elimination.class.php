<?php


#@todo: completely unfinished class. just scratch

class single_elimination extends bracket{
	
	public function __construct() {

		parent::__construct();
		
	}
	
	public function draw_bracket(){
		
		$qualified = self::get_qualified_teams();
		$size = sizeof($qualified);
		if ($size - pow(2, floor(log($size, 2))) != 0){return ('Unvalid number of teams chosen to be seeded in the single elimination bracket');}

		
		$chunked = array_chunk($qualified, sizeof($qualified)/2);
		$first = $chunked[0];
		$second = array_reverse($chunked[1]);
		
		$matches = array();
		
		while (sizeof ($first) > 0){
			$matches[] = array (array_shift($first), array_shift($second));
		}
		
		if (sizeof($matches) < 2){
			array_push($matches, '1.1');
			parent::store_matchlist($matches);
			return;
			
		}
		
		
		$chunked = array_chunk($matches, sizeof($matches)/2);
		$first = $chunked[0];
		$second = array_reverse($chunked[1]);
		
		$matchlist = array();
		$number_of_matches = $size/2;
		
		$i = 1;
		
		while (sizeof ($first) > 0){
			
			$match1 = array_shift($first);
			$match2 = array_shift($second);
			
			
			array_push($match1, $number_of_matches.'.'.$i);
			$i++;
			
			array_push($match2, $number_of_matches.'.'.$i);
			$i++;
			
			$matchlist[] = $match1;
			$matchlist[] = $match2;
			
			
			$first = array_reverse($first);
			$second = array_reverse($second);

		}
		
		$remaining = $number_of_matches/2;
		
		while ($remaining >= 1){
			for ($i=1; $i<=$remaining; $i++){
				$matchlist[] = array(-1, -1, $remaining.'.'.$i);
			}
			$remaining = $remaining/2;
		}
		
		parent::store_matchlist($matchlist);	

	}
	
	
	public function get_ranking(){
		
		$query = "
			SELECT
				m.identifier,
				m.team1 AS team1_id,
				m.team2 AS team2_id,
				IF(m.team1 <> 0, t1.name, 'tba') AS team1,
				IF(m.team2 <> 0, t2.name, 'tba') AS team2
			FROM
				gm_matches AS m
			LEFT JOIN gm_teams AS t1 ON t1.id = m.team1
			LEFT JOIN gm_teams AS t2 ON t2.id = m.team2
			WHERE
				bracket_id = '$this->id'
		";

		
		$results = db::fetch_results($query);
		
		return $results;

	}
	
	
	public function draw_ranklist(){
		
		$results = self::get_ranking();
		$number_of_matches = sizeof($results);
		$qualified = sizeof(self::get_qualified_teams());
		$rows = $qualified + ($qualified-1);
		
		echo '
			<table class="ranking"><tr>
		';
		$i = $qualified;
		while ($i/2 >= 1){
			echo '<th>Top '.$i.'</th><th rowspan="'.($rows+1).'">&nbsp;</th>';
			$i = $i/2;
		}
		
		echo '<th rowspan="'.(($rows/2)+1).'">WINNER</th></tr>';
		
		
		$i=0;
		while ($i<$rows){
			echo'';
			$i++;
		}
		
		
//		echo '
//			<table class="ranking">
//				<tr><th>no.</th><th>Team 1</th><th>Team 2</th><th>identifier</th></tr>
//		';
//		$i = 1;
//		foreach ($results as $match){
//			echo '<tr><td>'.$i.'.)</td><td>'.$match['team1'].'</td><td>'.$match['team2'].'</td><td>'.$match['identifier'].'</td></tr>';
//			$i++;
//		}
//		
//		echo '</table>';
	}
	
	
	public function process_finished_match($match_id){
		
		$match = new match();
		$match->load_entry($match_id);
		$identifier = explode('.', $match->get_identifier());
		$winner = $match->get_winner();
		
		$round = $identifier[0]/2;
		$match = $identifier[1];
		$which_team = $match%2;
		if ($which_team != 1){$which_team = 2;}
		$identifier = $round . '.' . ceil($match/2);
		
		
		$upc_match = new match();
		$id = $upc_match->select('id', "bracket_id='$this->id' AND identifier='$identifier'");
		$id = $id[0]['id'];
		$upc_match->load_entry($id);
		
		$method = 'set_team'.$which_team;
		$upc_match->$method($winner);
		
	}
}



?>
