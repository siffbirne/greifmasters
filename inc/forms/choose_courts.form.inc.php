<?php

#@todo: completely experimental. courts should be taken for the entire duration of the tournament. fuck it. everything else is to be regulated using the "playing times"

$start_time_h = new time_dropdown_element('start_time_h', 'h');
$start_time_m = new time_dropdown_element('start_time_m', 'm');
$end_time_h = new time_dropdown_element('end_time_h', 'h');
$end_time_m = new time_dropdown_element('end_time_m', 'm');

$courts = new court();
$result = $courts->list_entries();
$i=1;


?>


<form method="post" action="<?php echo $_SERVER['REQUEST_URI'] ; ?>">
<input type="hidden" name="submit" value="1" />

<table>
	<tr>
		<td>Start Time:</td>
		<td><?php echo $start_time_h->output().':'.$start_time_m->output();?></td>
	</tr>
	<tr>
		<td>End Time:</td>
		<td><?php echo $end_time_h->output().':'.$end_time_m->output();?></td>
	</tr>
	<tr>
		<td>Choose your courts:</td>
		<td>
			<table>
				<tr>
					<th>Choose</th>
					<th>Name</th>
					<th>Location</th>
				</tr>
			
			<?php 

				foreach ($result as $court){
					echo'
						<tr>
							<td>
								<input type="checkbox" name="court_'.$i.'" value="'.$court['id'].'">
							</td>
							<td>
								'.$court['name'].'
							</td>
							<td>
								'.$court['location'].'
							</td>
						</tr>
					';
					
					$i++;
				}
			
			
			
			?>
			</table>

		</td>
	</tr>
	<tr>
		<td colspan="2"><input type="submit" value="Submit" /></td>
	</tr>

</table>


</form>