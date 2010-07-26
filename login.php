<?php



if (isset ( $_GET ['login'] ) && $_GET ['login'] == 1) {

	if ($_POST ['user'] == "" || $_POST ['pw'] == "") {

		echo "ERROR! Please enter user name and password.<br />";

	} else {

		$user = strip_tags($_POST ['user']);
		$pw = strip_tags($_POST ['pw']);

		mysql_connect('localhost', 'root');
		mysql_select_db('greifmasters');

		$query = "SELECT * FROM users WHERE user='$user'";
		$pwcheck = mysql_query ( $query );

		while ( $row = mysql_fetch_array ( $pwcheck ) ) {
			$pwdb = $row ['pass'];
			$salt = $row ['salt'];
			$user_id = $row ['id'];
		}

		if (mysql_affected_rows () == 0) {

			echo "ERROR! Invalid user name.<br />";

		} elseif ($pwdb == md5 ( $pw . $salt . $user )) {

			session_start ();
			$_SESSION['admin']=TRUE;
			$_SESSION['user'] = $user_id;

			header ( "Location: admin" );
			exit;

		} else {
			echo "Login incorrect<br />";
		}

	}

}

?>


	<form method="POST" action="<?php echo $_SERVER['PHP_SELF']?>?login=1">
	User name: <input type="text" name="user" maxlength="15" /><br />
	Password: <input type="password" name="pw" maxlength="15" /><br />
	<input type="submit" name="login" value="Login"></form>
