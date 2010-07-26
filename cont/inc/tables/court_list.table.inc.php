<table class="t1">
	<tr>
		<th>Name</th>
		<th>Location</th>
		<th>Action</th>
	</tr>
	
	
<?php

$courts = new court();
$list = $courts->list_entries();


foreach ($list as $court){
	
	echo '
	<tr>
		<td>' . $court ['name'] . '</td>
		<td>' . $court ['location'] . '</td>
		<td>action</td>
	</tr>
	';

}



?>

</table>