<?php

function tournaments_table($ong_upc='', $query_extension=''){


	if ($ong_upc != ''){

		switch ($ong_upc) {

			case 'ong':
				$where_clause = 'status=2';
			break;

			case 'upc':
				$where_clause = 'status<2';
			break;

		}

	}

	$tournaments = new tournament();
	$tournaments = $tournaments->select(
		"id,
		name,
		city,
		DATE_FORMAT(begin,'%d.%m.%Y') AS begin_date,
		DATE_FORMAT(end,'%d.%m.%Y') AS end_date,
		status",
		$where_clause
		
	);

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


	if ($tournaments == FALSE){
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