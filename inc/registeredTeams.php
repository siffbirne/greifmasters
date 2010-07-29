<?php
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
		array( "L'Equipe", 'Geneva', 'Lukas Keller', 'Manuel Loup','Mario Rhyner', 'Lequipe.jpg'),
		array( 'Los Coños', 'London', 'Sarah Cole', 'Jo Shippey','Ali Warwood', 'LosConos.gif'),
		array( 'Malice International', 'London', 'Andrew Fernandez', 'Iain Pate','Matt Vidal', 'Malice.gif'),
		array( 'Metz, Schindel & Söhne', 'Karlsruhe', 'Thomas Metz', 'Alexander Schindel', 'Max Thomas', 'MetzSchindel.gif'),
		array( 'MGM', 'Paris', 'Grégory Barbier', 'Matthieur Bachelier','Mathieu Battelier', 'MGM.jpg'),
		array( 'Netto Superstars', 'Manchester', 'Andrew McRae', 'Miroslaw Steadman', 'Adam Russ', 'netto.gif'),
		array( 'O69ers (Oh, sixtyniners)', 'Frankfurt', 'Frederick Stautz', 'Markus Wenda', 'Jonas Kölbel', 'o69ers.gif'),
		array( 'Pipe Gang Dodici Team', 'Milano', 'Bozo', 'Ortu', 'Frank', 'PipeGang.gif'),
		array( "Polo d'Oro", 'Karlsruhe', 'Recep Ye&#351;il', 'Oli Witzemann', 'Oli Scheib', 'PoloDoro.gif'),
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
mysql_connect('localhost', 'root');
mysql_select_db('greifmasters');
	
	
foreach($theTeams as $team){
	$query="INSERT INTO gm_teams (name, city, player1, player2, player3, logo, created_by) VALUES ('$team[0]', '$team[1]', '$team[2]', '$team[3]', '$team[4]', '$team[5]', '2')";
	mysql_query($query);
}
		
?>
	