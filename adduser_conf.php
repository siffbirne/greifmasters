<?php
include_once 'inc/functions.inc.php';
include_once 'inc/db.inc.php';


$pw="321penis";
$user="greifmaster";

$salt=substr(md5(uniqid()),2,8);
$md5=md5($pw.$salt.$user);

mysql_query("INSERT INTO users (user,salt,pass) VALUES ('$user','$salt','$md5')");
echo "affected rows".mysql_affected_rows()."<br />".mysql_error();



?>