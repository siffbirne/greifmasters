<?php



if (isset ( $_GET ['login'] ) && $_GET ['login'] == 1) {

	if ($_POST ['user'] == "" || $_POST ['pw'] == "") {

		echo "ERROR! Please enter user name and password.<br />";

	} else {

		$user = strip_tags($_POST ['user']);
		$pw = strip_tags($_POST ['pw']);
		
		$db = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

		$query = "SELECT * FROM gm_users WHERE user='$user'";
		$result = $db->query($query);

		while ( $row = $result->fetch_object() ) {
			$pwdb = $row->pass;
			$salt = $row->salt;
			$user_id = $row->id;
			$rights = $row->rights;
		}

		if ($result->num_rows == 0) {

			echo "ERROR! Invalid user name.<br />";

		} elseif ($pwdb == md5 ( $pw . $salt . $user )) {

			session_start ();
			if ($rights == 'admin'){
				$_SESSION['admin']=TRUE;
			}
			
			$_SESSION['user'] = $user_id;
			$_SESSION['rights'] = $rights;

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
