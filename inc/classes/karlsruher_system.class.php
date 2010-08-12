<?php



class karlsruher_system extends bracket {

	
	protected $calculated_time;
	protected $mode = 1;
	#@todo: "mode" deprecated?
	protected $number_of_matches;

	
#@todo: bunch of variables missing


	public function __construct() {

		parent::__construct();
		
	}
	
	

	public function store($bracket_name, $timelimit_policy=''){
		
		$this->bracket_name = $bracket_name;
		$this->type = 'karlsruher_system';
		
		$this->timelimit5 = $timelimit_policy[0][0];
		$this->pause5 = $timelimit_policy[0][1];
		$this->timelimit4 = $timelimit_policy[1][0];
		$this->pause4 = $timelimit_policy[1][1];
		$this->timelimit3 = $timelimit_policy[2][0];
		$this->pause3 = $timelimit_policy[2][1];
		$this->timelimit2 = $timelimit_policy[3][0];
		$this->pause2 = $timelimit_policy[3][1];
		$this->timelimit1 = $timelimit_policy[4][0];
		$this->pause1 = $timelimit_policy[4][1];
		
		parent::store();
		
		
	}
	
	
	
	
	
	public function get_calculated_time($format){
		parent::get_calculated_time($format);
	}
	
	public function calculate_time(){
		
		#@todo: for elimination style brackets this calculation has to take into consideration that timelimits can differ.
		return self::get_number_of_matches()*($this->match_duration+$this->pause);
	}
	
	public function get_number_of_matches(){
		
		return parent::get_number_of_teams()*$this->offset;
		
	}
	
	
	public function draw_bracket($offset, $shuffle = FALSE){
		

		
		$matchlist = array();
		
		$seeding = self::get_seeding();
		$number_of_teams = sizeof($seeding);
		
		while( list ( $key, $row ) = each ( $seeding ) ){
		#foreach ($seeding as $row){
			#$team = new team();
			for ($i=1; $i<=$offset; $i++){

			#@todo: check if the -1 as identifier affects the shuffle-function (called below). was only tested with arrays like (team1, team2). the third index will most probably cause false results.
				
				if ($key+$i < $number_of_teams){
					$opponent = $seeding[$key+$i]['team_id'];
					$matchlist[]=array($seeding[$key]['team_id'], $opponent, -1);
				}
				
				if($key - $i < 0){
					$opponent = $seeding[$key + $number_of_teams - $i]['team_id'];
					$matchlist[]=array($seeding[$key]['team_id'], $opponent, -1);
				}
				
			}
		}

		


		
		$matchlist = shuffle_matchlist($matchlist,$number_of_teams);
	#@todo: seperate the shuffle function, or add a possibility to skip that step

		
		
		parent::store_matchlist($matchlist);
	}
	
	

	public function get_ranking($limit = '', $ranking_only = FALSE){
		
		
		#FIXME: query is complete crap and just hacked together
		
		$query = "

		SELECT
		t.name AS team,
		t.id AS team_id,
		t.city AS city,
		p1.name AS player1,
		p2.name AS player2,
		p3.name AS player3,

				
		(
			SELECT
				count(*)
			FROM
				gm_matches AS m
			WHERE
				(team1 = t.id
				OR
				team2 = t.id)
			AND
				status ='1'
			AND
				(
					SELECT
						count(*)
					FROM
						gm_goals
					WHERE(
						((team_id = t.id AND regular = '1')
						OR
						(team_id != t.id AND regular = '0'))
						AND
						match_id = m.id
						)
				) > (
					SELECT
						count(*)
					FROM
						gm_goals
					WHERE(
						((team_id != t.id AND regular = '1')
						OR
						(team_id = t.id AND regular = '0'))
						AND
						match_id = m.id
						)
				)
							
			AND
				bracket_id = '".$this->id."'
		) AS matches_won,
		
		
		
		
				(
			(SELECT
				count(*) * 3
			FROM
				gm_matches AS m
			WHERE
				(team1 = t.id
				OR
				team2 = t.id)
			AND
				status ='1'
			AND
				(
					SELECT
						count(*)
					FROM
						gm_goals
					WHERE(
						((team_id = t.id AND regular = '1')
						OR
						(team_id != t.id AND regular = '0'))
						AND
						match_id = m.id
						)
				) > (
					SELECT
						count(*)
					FROM
						gm_goals
					WHERE(
						((team_id != t.id AND regular = '1')
						OR
						(team_id = t.id AND regular = '0'))
						AND
						match_id = m.id
						)
				)
							
			AND
				bracket_id = '".$this->id."'
		) +
		
		
						(
			SELECT
				count(*)
			FROM
				gm_matches AS m
			WHERE
				(team1 = t.id
				OR
				team2 = t.id)
			AND
				status ='1'
			AND
				(SELECT count(*) FROM gm_goals WHERE team_id = t.id AND match_id = m.id) = (SELECT count(*) FROM gm_goals WHERE team_id != t.id AND match_id = m.id)
			AND
				bracket_id = '".$this->id."'
		)
		
		
		
		) AS points,
		
		
		
		
		
		(
			SELECT
				count(*)
			FROM
				gm_matches AS m
			WHERE
				(team1 = t.id
				OR
				team2 = t.id)
			AND
				status ='1'
			AND
				(
					SELECT
						count(*)
					FROM
						gm_goals
					WHERE(
						((team_id = t.id AND regular = '1')
						OR
						(team_id != t.id AND regular = '0'))
						AND
						match_id = m.id
						)
				) < (
					SELECT
						count(*)
					FROM
						gm_goals
					WHERE(
						((team_id != t.id AND regular = '1')
						OR
						(team_id = t.id AND regular = '0'))
						AND
						match_id = m.id
						)
				)
							
			AND
				bracket_id = '".$this->id."'
		) AS matches_lost,
		
		
		
		
		
		
				(
			SELECT
				count(*)
			FROM
				gm_matches AS m
			WHERE
				(team1 = t.id
				OR
				team2 = t.id)
			AND
				status ='1'
			AND
				(SELECT count(*) FROM gm_goals WHERE team_id = t.id AND match_id = m.id) = (SELECT count(*) FROM gm_goals WHERE team_id != t.id AND match_id = m.id)
			AND
				bracket_id = '".$this->id."'
		) AS matches_draw,
		
		
		
		
		
		
		(
			SELECT
				count(*)
			FROM
				gm_goals
			WHERE
				((team_id = t.id AND regular = '1')
				OR
				(team_id != t.id AND regular = '0'))
			AND
				match_id IN (SELECT id FROM gm_matches WHERE (team1=t.id OR team2=t.id) AND bracket_id = '".$this->id."' AND status ='1')
		) AS goals,
		
		
		
		
		(
			(SELECT
				count(*)
			FROM
				gm_goals
			WHERE
				((team_id = t.id AND regular = '1')
				OR
				(team_id != t.id AND regular = '0'))
			AND
				match_id IN (SELECT id FROM gm_matches WHERE (team1=t.id OR team2=t.id) AND bracket_id = '".$this->id."' AND status ='1')
			) -
			(
			SELECT
				COUNT(*)
			FROM
				gm_goals 
			WHERE
				((team_id != t.id AND regular = '1')
				OR
				(team_id = t.id AND regular = '0'))
			AND
				match_id IN (SELECT id FROM gm_matches WHERE (team1=t.id OR team2=t.id) AND bracket_id = '".$this->id."' AND status ='1')
		)
		) AS goal_difference,
		
		
		
		
		(
			SELECT
				COUNT(*)
			FROM
				gm_goals 
			WHERE
				((team_id != t.id AND regular = '1')
				OR
				(team_id = t.id AND regular = '0'))
			AND
				match_id IN (SELECT id FROM gm_matches WHERE (team1=t.id OR team2=t.id) AND bracket_id = '".$this->id."' AND status ='1')
		) AS goals_against,
		
		
		
		
		
		
		(
			SELECT
				COUNT(*)
			FROM
				gm_matches
			WHERE
				status >= '1'
			AND
				(team1 = t.id
				OR
				team2 = t.id)
			AND
				status ='1'
			AND
				bracket_id = '".$this->id."'
		) AS games_played
		
		
		
		FROM
		gm_bracket_qualifications AS q
		INNER JOIN gm_teams AS t ON q.team_id = t.id
		INNER JOIN gm_players AS p1 ON t.player1 = p1.id
		INNER JOIN gm_players AS p2 ON t.player2 = p2.id
		INNER JOIN gm_players AS p3 ON t.player3 = p3.id
		WHERE
			q.bracket_id='".$this->id."'
	";
//		$query = "
//
//		SELECT
//		t.name AS team,
//		t.id AS team_id,
//		t.city AS city,
//		p1.name AS player1,
//		p2.name AS player2,
//		p3.name AS player3,
//		all_matches.count(id) AS matches_played,
//		matches_won.count(id) AS won,
//		matches_lost.count(id) AS lost,
//		matches_draw.count(id) AS draw,
//		matches_won.count(id) * 3 + matches_draw.count(id) AS points,
//		all_goals.count(id) AS goals,
//		all_goals_against.count(id) AS goals_against,
//		all_goals.count(id) - all_goals_against.count(id) AS goal_difference,
//		
//		
//		FROM
//		
//		
//		
//		
//			gm_bracket_qualifications AS q,
//			
//			
//			(SELECT
//					id
//				FROM
//					gm_matches AS m
//				WHERE
//					(team1 = t.id
//					OR
//					team2 = t.id)
//				AND
//					status ='1'				
//				AND
//					bracket_id = '".$this->id."'
//			) AS all_matches,
//			
//			
//			
//			(SELECT
//				id
//			FROM
//				gm_goals
//			WHERE
//				team_id = t.id
//			AND
//				((team_id = t.id AND regular = '1')
//				OR
//				(team_id != t.id AND regular = '0'))
//			AND
//				match_id IN (SELECT id FROM all_matches)
//			) AS all_goals,
//			
//			
//			(SELECT
//				id
//			FROM
//				gm_goals
//			WHERE
//				team_id = t.id
//			AND
//				((team_id != t.id AND regular = '1')
//				OR
//				(team_id = t.id AND regular = '0'))
//			AND
//				match_id IN (SELECT id FROM all_matches)
//			) AS all_goals_against,
//			
//			
//			
//			(SELECT
//					id
//				FROM
//					all_matches
//				WHERE
//					(
//						SELECT
//							count(*)
//						FROM
//							all_goals
//						WHERE
//							all_goals.match_id = id
//					) > (
//						SELECT
//							count(*)
//						FROM
//							all_goals_against
//						WHERE
//							all_goals_against.match_id = id
//					)
//			) AS matches_won,
//			
//			
//			
//			(SELECT
//					id
//				FROM
//					all_matches
//				WHERE
//					(
//						SELECT
//							count(*)
//						FROM
//							all_goals
//						WHERE
//							all_goals.match_id = id
//					) < (
//						SELECT
//							count(*)
//						FROM
//							all_goals_against
//						WHERE
//							all_goals_against.match_id = id
//					)
//			) AS matches_lost,
//			
//
//			
//			(SELECT
//					id
//				FROM
//					all_matches
//				WHERE
//					(
//						SELECT
//							count(*)
//						FROM
//							all_goals
//						WHERE
//							all_goals.match_id = id
//					) = (
//						SELECT
//							count(*)
//						FROM
//							all_goals_against
//						WHERE
//							all_goals_against.match_id = id
//					)
//			) AS matches_draw,
//		
//		
//		INNER JOIN gm_teams AS t ON q.team_id = t.id
//		INNER JOIN gm_players AS p1 ON t.player1 = p1.id
//		INNER JOIN gm_players AS p2 ON t.player2 = p2.id
//		INNER JOIN gm_players AS p3 ON t.player3 = p3.id
//		WHERE
//			q.bracket_id='".$this->id."'
//	";
	
	
	$query .= "
		ORDER BY points DESC, matches_won DESC, matches_lost ASC, goal_difference DESC, goals DESC, goals_against ASC
	";
	
	if (is_numeric($limit)){$query .= "LIMIT ".$limit." \n";}
	
	
	$results = parent::fetch_results($query);
	
	if ($ranking_only == TRUE){
		foreach ($results as $index => $result){
			$results[$index] = array('id' => $result['team_id']);
		}
	}
	
	
	return $results;

	}
	
	
	public function draw_ranklist(){
		
		$results = self::get_ranking();

		echo '
			<table class="ranking">'."\n".'
				<tr><th>Rank</th><th>Team name</th><th>Points</th><th>won</th><th>lost</th><th>draw</th><th>goal difference</th><th>goals</th><th>goals against</th><th>games played</th></tr>'."\n".'
		';
		$i = 1;
		foreach ($results as $team){
			echo '
				<tr>
					<td>'.$i.'.)</td>
					<td title="'.$team['player1'].', '.$team['player2'].', '.$team['player3'].' ('.$team['city'].')">'.$team['team'].'</td>
					<td>'.$team['points'].'</td>
					<td>'.$team['matches_won'].'</td>
					<td>'.$team['matches_lost'].'</td>
					<td>'.$team['matches_draw'].'</td>
					<td>'.$team['goal_difference'].'</td>
					<td>'.$team['goals'].'</td>
					<td>'.$team['goals_against'].'</td>
					<td>'.$team['games_played'].'</td>
				</tr>
			';
			$i++;
		}
		
		echo '</table>';
	}
	
	
}

?>