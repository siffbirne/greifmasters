
<ul id="ajax_list" class="sortable">

<?php

$upc_matches = new upc_match ( );

$query = "
	SELECT
		u.id AS id,
		u.match_id AS match_id,
		t1.name AS team1,
		t2.name AS team2,
		m.team1 AS team1_id,
		m.team2 AS team2_id
	FROM
		gm_upc_matches AS u
		INNER JOIN gm_matches AS m ON m.id = u.match_id
		INNER JOIN gm_teams AS t1 ON m.team1 = t1.id
		INNER JOIN gm_teams AS t2 ON m.team2 = t2.id
	WHERE
		m.bracket_id = '".$_SESSION['bracket_id']."'
	ORDER BY u.match_order ASC, u.id ASC
	LIMIT 5
";


$list = $upc_matches->fetch_results($query);


foreach ( $list as $row ) {

	
	echo '<li id="item_' . $row ['match_id'] . '">' . $row['team1'] . ' : ' . $row['team2'] . '</li>';
	echo "\n";
}

?>
</ul>


<script type="text/javascript">

Sortable.create("ajax_list",
	{
	onUpdate:function()
		{
		new Ajax.Request('/greifmasters/inc/functions/ajax/matches_sort.function.inc.php',
			{
			method: "post",
			parameters: {data: Sortable.serialize("ajax_list")}
			});
		
		}
	});
</script>

<?php #window.location.reload();?>