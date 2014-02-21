
<!doctype html>
<html>
<head>
<meta charset="UTF-8">
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
    <a href="authentication.php?logout">Logout</a>
</body>
</html>