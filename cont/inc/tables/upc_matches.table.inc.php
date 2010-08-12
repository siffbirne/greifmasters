<?php
if (isset ( $_GET ['p4'] ) && $_GET ['p4'] == 'sort'){
			
	parse_str($_POST['data']);
	
	#require_once ('../../functions.inc.php');
	$db = new db('upc_matches');
	
	for ($offset_count = 0; $offset_count < count($ajax_list); $offset_count++) {
		if(is_int($offset_count)) {
			$db->update("match_order = '$offset_count'", "match_id = '$ajax_list[$offset_count]'");
		}
		else {
		exit;
		}
	}
			
}

echo '<ul id="ajax_list" class="sortable">';


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
		AND u.court_id = '".$_SESSION['court_id']."'
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
		new Ajax.Request('<?=BASE?>/play_tournament/matches/ong/<?php echo $_SESSION['court_id']; ?>/sort',
			{
			method: "post",
			parameters: {data: Sortable.serialize("ajax_list")}
			});
		
		}
	});
</script>

<?php #window.location.reload();?>