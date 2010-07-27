<div id="navBoxesContainer">

	<div class="navBox">
		<div class="navHeading">Tournaments</div>

		<div class="navContent">
			<a href="/greifmasters/admin/list_tournaments/ong">ongoing</a><br />
			<a href="/greifmasters/admin/list_tournaments/upc">upcoming</a><br />
			<a href="/greifmasters/admin/list_tournaments">all</a>
		</div>
	</div>

	<div class="navBox">
		<div class="navHeading">Teams</div>
		<div class="navContent">
			<a href="<?php echo BASE;?>/teams/create">Create new team</a><br />
			<a href="<?php echo BASE;?>/teams">Show teams</a>
		</div>
	</div>
	
	<div class="navBox">
		<div class="navHeading">Courts</div>
		<div class="navContent">
			<a href="/greifmasters/admin/courts/create">Create new court</a><br />
			<a href="/greifmasters/admin/courts">Show courts</a>
		</div>
	</div>
	
	<div class="navBox">
		<div class="navHeading">Controls</div>
		<div class="navContent">
			<a href="/greifmasters/admin/setup">Setup new tournament</a><br />
			<a href="/greifmasters/admin/logout">Logout</a>
		</div>
	</div>

	<?php 
	if ($_SESSION['admin'] == TRUE){
	?>
	<div class="navBox">
		<div class="navHeading">Admin</div>
		<div class="navContent">
			<a href="/greifmasters/admin/test_code">test_code.php</a><br />
			<a href="/greifmasters/admin/debug_mode">Toggle debug mode</a><br />
			<a href="/greifmasters/session_destroy.php">destroy session</a><br />
			<a href="/greifmasters/admin/settings">Settings</a>
		</div>
	</div>
	
	<?php 
	}
	?>
</div>