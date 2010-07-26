<?php

function tournaments_table($ong_upc='', $query_extension=''){

	$tournaments = array();

	$query = "
		SELECT
			id,
			name,
			city,
			DATE_FORMAT(begin,'%d.%m.%Y') AS begin_date,
			DATE_FORMAT(end,'%d.%m.%Y') AS end_date,
			status
		FROM
			tournaments
	";


	if ($ong_upc != ''){

		switch ($ong_upc) {

			case 'ong':
				$query .= query_extension("WHERE", "status=2");
			break;

			case 'upc':
				$query .= query_extension("WHERE", "status<2");
			break;

		}

	}


	$result = mysql_query ( $query ) or die ( mysql_error () );

	while ($data = mysql_fetch_assoc($result)){

		array_push($tournaments, $data);

	}



	#echo $query;

	echo '
		<table>
			<tr>
				<th>Name</th>
				<th>City</th>
				<th>Begin</th>
				<th>End</th>
				<th>Status</th>
			</tr>
	';


	if (mysql_affected_rows() == 0){
			echo end_table(5);
			return;
	}

	foreach ($tournaments as $row){

		$edit = BASE.'/tournament/'.$row ['id'];

		$status = translate_status($row['status']);

		echo '
			<tr>
				<td><a href="'.$edit.'">' . $row ['name'] . '</a></td>
				<td>' . $row ['city'] . '</td>
				<td>' . $row ['begin_date'] . '</td>
				<td>' . $row ['end_date'] . '</td>
				<td>' . $status . '</td>
			</tr>
		';
	}

	echo '</table>';

}