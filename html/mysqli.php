<?php
$db_obj = new mysqli("mysql.nesh.co", "bammnesh", "SCUedu11..", "neshco");

if(mysqli_connect_errno())
{
	printf("Can't connect. Errorcode: %s\n", mysqli_connect_error());
	exit;
}
?>