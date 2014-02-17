<!doctype html>
<html>
<head>
<meta charset="UTF-8">
<link rel="stylesheet" type="text/css" href="../styles/styles.css">
<title>NESH</title>
</head>

<body>
	<?php
		session_start();
		if(!isset($_SESSION['userid'])){
			header("Location: index.html");
		}
	?>
	<p> You are in!</p>
    <a href="../php/authentication.php?logout">Logout</a>
</body>
</html>