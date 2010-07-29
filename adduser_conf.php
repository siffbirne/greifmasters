<?php
include_once 'inc/functions.inc.php';

mysql_connect('localhost', 'root');
mysql_select_db('greifmasters');


$pw="123penis";
$user="stefan";

$salt=substr(md5(uniqid()),2,8);
$md5=md5($pw.$salt.$user);
$query = "INSERT INTO gm_users (user,salt,pass) VALUES ('$user','$salt','$md5')";
mysql_query($query);
echo $query.'<br>';
echo "affected rows".mysql_affected_rows()."<br />".mysql_error();



?>