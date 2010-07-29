<?php

# just some useless file for quick testing
for ($i=0; $i<20; $i++){$team = new team();
$team->store("test team $i", "city $i", "dummy1", "dummy2", "dummy3");}

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
				matches AS m
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
						goals
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
						goals
					WHERE(
						((team_id != t.id AND regular = '1')
						OR
						(team_id = t.id AND regular = '0'))
						AND
						match_id = m.id
						)
				)
							
			AND
				bracket_id = '".$bracket->get_id()."'
		) AS matches_won,
		
		
		
		
		
		
		
		(
			SELECT
				count(*)
			FROM
				matches AS m
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
						goals
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
						goals
					WHERE(
						((team_id != t.id AND regular = '1')
						OR
						(team_id = t.id AND regular = '0'))
						AND
						match_id = m.id
						)
				)
							
			AND
				bracket_id = '".$bracket->get_id()."'
		) AS matches_lost,
		
		
		
		
		
		
				(
			SELECT
				count(*)
			FROM
				matches AS m
			WHERE
				(team1 = t.id
				OR
				team2 = t.id)
			AND
				status ='1'
			AND
				(SELECT count(*) FROM goals WHERE team_id = t.id AND match_id = m.id) = (SELECT count(*) FROM goals WHERE team_id != t.id AND match_id = m.id)
			AND
				bracket_id = '".$bracket->get_id()."'
		) AS matches_draw,
		
		
		
		
		
		
		(
			SELECT
				count(*)
			FROM
				goals
			WHERE
				((team_id = t.id AND regular = '1')
				OR
				(team_id != t.id AND regular = '0'))
			AND
				match_id IN (SELECT id FROM matches WHERE (team1=t.id OR team2=t.id) AND bracket_id = '".$bracket->get_id()."' AND status ='1')
		) AS goals,
		
		
		
		
		
		
		(
			SELECT
				COUNT(*)
			FROM
				goals 
			WHERE
				((team_id != t.id AND regular = '1')
				OR
				(team_id = t.id AND regular = '0'))
			AND
				match_id IN (SELECT id FROM matches WHERE (team1=t.id OR team2=t.id) AND bracket_id = '".$bracket->get_id()."' AND status ='1')
		) AS goals_against,
		
		
		
		
		
		
		(
			SELECT
				COUNT(*)
			FROM
				matches
			WHERE
				status >= '1'
			AND
				(team1 = t.id
				OR
				team2 = t.id)
			AND
				status ='1'
			AND
				bracket_id = '".$bracket->get_id()."'
		) AS games_played
		
		
		
	FROM
		teams AS t
	INNER JOIN players AS p1 ON t.player1 = p1.id
	INNER JOIN players AS p2 ON t.player2 = p2.id
	INNER JOIN players AS p3 ON t.player3 = p3.id
	WHERE
		t.id IN (
			SELECT
				team1
			FROM
				matches
			WHERE
				bracket_id='".$bracket->get_id()."'
		)
	OR
		t.id IN (
			SELECT
				team2
			FROM
				matches
			WHERE
				bracket_id='".$bracket->get_id()."'
		)
	
	ORDER BY matches_won DESC, goals DESC, goals_against ASC
";
//$teams = array(1,2,3,4,5);
//
//$matchlist = array(
//	array(1,2),
//	array(1,3),
//	array(1,4),
//	array(1,5),
//	array(2,3),
//	array(2,4),
//	array(2,5),
//	array(3,4),
//	array(3,5),
//	array(4,5)
//);
//
//
////while ($pointer <= $last_index){
////	$compare = $pointer+1;
////	
////	$swapped = FALSE;
////	
////	if (in_array($matchlist[$compare][0], $matchlist[$pointer]) || in_array($matchlist[$compare][1], $matchlist[$pointer])){
////		
////		$cache = $matchlist[$last_index];
////		$matchlist[$last_index] = $matchlist[$compare];
////		$matchlist[$compare] = $cache;
////		
////		$swapped = TRUE;
////		var_dump($matchlist);echo "<br><br>";
////		
////	}
////	
////	if ($swapped == TRUE){$pointer++;}
////}
//
//$shuffled = array();
//$exception = FALSE;
//
//
//$mingap = floor((sizeof($teams)-3)/2);
//
//
//while (sizeof($matchlist)>0) {
//
//	$didsomething = FALSE;
//	
//	for ($i=0; $i<sizeof($matchlist); $i++){
//	
//		$each = each($matchlist);
//		if ($each == FALSE){reset($matchlist); $each = each($matchlist);}
//		$index = $each[0];
//		$match = $each[1];
//		$k = sizeof($shuffled);
//		
//	
//		$passt = TRUE;
//		
//		for($j=0; $j<=$mingap; $j++){
//
//				
//			if (isset ($shuffled[$k-$j]) && ( in_array($match[0],$shuffled[$k-$j]) || in_array($match[1],$shuffled[$k-$j]))){
//				$passt = FALSE;			
//			}
//			
//		}
//		
//		if ($passt == TRUE || $exception == TRUE){
//			array_push($shuffled,$match);
//			$didsomething = TRUE;
//			$exception = FALSE;
//			unset ($matchlist[$index]);
//
//			
//		}
//	//					foreach($matchlist as $match){
//	//				echo $match[0]." : ".$match[1]."<br>";
//	//			}echo "<br><br>";
//	}
//	
//	if ($didsomething == FALSE){
//		$exception = TRUE;
//	}
//}
//
//
//
//
//foreach($shuffled as $match){
//	echo $match[0]." : ".$match[1]."<br>";
//}










	$theTeams = array (
		array( '3P Polo', 'Bielefeld', 'Daniel Adriaans', 'David Schmitt','Sascha Georg', 'Default.gif'),
		array( 'Apologies Accepted', 'Paris', 'Marc Sich', 'Luis David','Alex', 'Default.gif'),
		array( 'BAD Polo', 'London', 'Brendan McNamee', 'Aidan Earl','Dave Tappy', 'BadPolo.gif'),
		array( 'Bambule', 'Berlin', 'Mathias Jestrinski', 'Danny Balzer','Niko', 'Default.gif'),
		array( 'Basel 1', 'Basel','David Beerli', 'Domonique Candik', 'Jérôme Thierit', 'Default.gif'),
		array( 'Basel 2', 'Basel', 'Salome Thierstein', 'Ruedy Bollack','Beda Kamm', 'Default.gif'),
		array( 'Berlin 1', 'Berlin', 'Marc Brockmann', 'Stefan Lechleitner','Morgan Allen', 'Default.gif'),
		array( 'Black Rebellion', 'London', 'Roxy Erickson', 'Dan Howarth','tba', 'Default.gif'),
		array( 'Candy Colored Clowns', 'Karlsruhe', 'Steffen Mackert', 'Hannes Hengst','Marc Malkowski', 'CandyColoredClowns.gif'),
		array( 'Chain Bastards', 'Konstanz', 'David Stuhldreier', 'Alexander Bucher','Peter Becker', 'logo_chain bastards.gif'),
		array( 'Cosmic3', 'London', 'Mat Horwood', 'Tom Williams','Andrew Todd', 'Cosmic.jpg'),
		array( 'Dans ta Gueule Puceau', 'Paris', 'Hugo Laquerbe', 'Pierre','Surprise', 'DansTaGueule.gif'),
		array( 'Der Klub', 'Barcelona', 'Lucas Prescivalle', 'Tomaso Belle','Enrico Belle', 'Default.gif'),
		array( 	'Flying Mallets', 'Hannover', 'Thommy', 'Tim','Tom', 'Default.gif'),
		array( 	'Iron Ponies', 'Geneva', 'Quentin Bailat', 'Johan Binggeli','Clément Bailat', 'IronPony.jpg'),
		array( 'Jap-Italo-Dutchy squad', 'Eindhoven', 'Takahiro Honda', 'Lorenzo Bassani','Bram van Oosten', 'JapItalo.gif'),
		array( 'Karlsruhe 4', 'Karlsruhe', 'Simon Hansmann', 'tba','tba', 'Default.gif'),
		array( 'L&#39;Equipe', 'Geneva', 'Lukas Keller', 'Manuel Loup','Mario Rhyner', 'Lequipe.jpg'),
		array( 'Los Coños', 'London', 'Sarah Cole', 'Jo Shippey','Ali Warwood', 'LosConos.gif'),
		array( 'Malice International', 'London', 'Andrew Fernandez', 'Iain Pate','Matt Vidal', 'Malice.gif'),
		array( 'Metz, Schindel & Söhne', 'Karlsruhe', 'Thomas Metz', 'Alexander Schindel', 'Max Thomas', 'MetzSchindel.gif'),
		array( 'MGM', 'Paris', 'Grégory Barbier', 'Matthieur Bachelier','Mathieu Battelier', 'MGM.jpg'),
		array( 'Netto Superstars', 'Manchester', 'Andrew McRae', 'Miroslaw Steadman', 'Adam Russ', 'netto.gif'),
		array( 'O69ers (Oh, sixtyniners)', 'Frankfurt', 'Frederick Stautz', 'Markus Wenda', 'Jonas Kölbel', 'o69ers.gif'),
		array( 'Pipe Gang Dodici Team', 'Milano', 'Bozo', 'Ortu', 'Frank', 'PipeGang.gif'),
		array( 'Polo d&#39;Oro', 'Karlsruhe', 'Recep Ye&#351;il', 'Oli Witzemann', 'Oli Scheib', 'PoloDoro.gif'),
		array( 'Poloholic Anonymus', 'München', 'Lorenz Böck', 'Til Ludwig', 'Marcus Brenner', 'Default.gif'),
		array( 'Poloholica', 'München', 'Anja Müller', 'Angeliki Tsokou', 'Katrin Moder', 'Poloholica.gif'),
		array( 'POLOsynthese', 'Frankfurt', 'Anna-Catharina Arnold', 'David Löffler', 'Moritz Trautmann', 'Polosynthese.gif'),
		array( 'Querschläger', 'Hannover', 'Niels', 'Florian Hertweck', 'Hannes', 'Default.gif'),
		array( 'Qui Quo Qua - Stoccarda', 'Stuttgart', 'Daniele Barcheri', 'Sebastian Feix', 'Dennis Fischer', 'QuiQuoQua.gif'),
		array( 'Riding in Circle', 'Vincenza', 'Stefano Cento', 'Tobia Molinari', 'Gianluca Peloso', 'RidingInCircle.gif'),
		array( 'Rotten Apples', 'London', 'Emilié Charter-Obrien', 'Ricardo Campano', 'Gabriel Bucknall', 'RottenApples.gif'),
		array( 'Saucy Lobstarz', 'Paris', 'Nicolas Veyssiere', 'Alexandre Rabineau', 'Henri Riton', 'SaucyLobstarz.gif'),
		array( 'Team Burzum Mediolanum', 'Milano', ' Lorenzo Z&uuml;rcher', 'David Steinhorst', 'Nora Orha', 'TeamBurzum.gif'),
		array( 'Three Beards, One Cup', 'London', 'Rupert Evans-Harding', 'Marc Hill', 'Bill Chidley', 'ThreeBeards.gif'),
		array( 'Toros', 'München', 'Andreas "Shustar" Schuster', 'Eduard "Special Ed" Krömer', 'James R. Miller', 'Default.gif'),
		array( 'Wheelo', 'Konstanz', 'Bernd Kromer', 'Saade Ye&#351;il', 'Daniel Meier', 'logo_wheelo.gif'),
		array( 'Zombie United', 'London', 'Yorgo Tloupas', 'Mike Kangelos', 'Hassan Raheem', 'Zombie.gif'),
		array( 'Special','tba', 'tba', 'tba', 'tba', 'Default.gif')
		
	);
	#EastVan'East Van', 'Vancouver', 'Max Knight', '','', 'defaultTeam.gif',
	#		'', '', '', '', '', 'defaultTeam.gif'
	# array( 'Barcelona 2', 'Barcelona', 'tba', 'tba','tba', 'Default.gif'),


	
foreach($theTeams as $team){
	$neu = new team();
	$neu->store($team[0],$team[1],$team[2],$team[3],$team[4], $team[5]);

}

?>