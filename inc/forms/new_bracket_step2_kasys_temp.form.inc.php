<form action="<?php echo BASE?>/play_tournament/brackets/new/" method="post">
<input type="hidden" name="nextstep" value="3" />
Select offset:<br />
<select name="offset">
	<option value="1">1</option>
	<option value="2">2</option>
	<option value="3">3</option>
	<option value="4">4</option>
	<option value="5">5</option>
	<option value="6">6</option>
</select><br />

set order of teams:<br /><br />

<ul id="ajax_list">

<?php

	
	$db = new db('seeding');
	
    $result = $db->fetch_results("SELECT * FROM seeding ORDER BY value");
	$offset_count = 1;
    foreach ($result as $data)
    {
    	$team = new team();
		echo '<li id="item_'. $data['id'] .'">'. $offset_count. '.) ' . $team->get_name_by_id($data['id']) .'</li>';
		echo "\n";
		$offset_count++;
	}
?>
</ul>

<script type="text/javascript">
Sortable.create("ajax_list",
	{
	onUpdate:function()
		{
		new Ajax.Request('/greifmasters/inc/functions/ajax/seeding_sort.function.inc.php',
			{
			method: "post",
			parameters: {data: Sortable.serialize("ajax_list")}
			});
		}
	});
</script>

<input type="submit" value="Done seeding" />


</form>