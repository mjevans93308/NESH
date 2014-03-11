<?php
		session_start();
		if(!isset($_SESSION['userid'])){
			header("Location: ../index.html");
		}
?>
<!doctype html>
<html>
<head>
<meta charset="UTF-8">
<title>NESH</title>
<link rel="stylesheet" type="text/css" href="../styles/style.css">
</head>

<body>
<h3>Welcome! <?php echo $_SESSION['userid'] ?> </h3>
	<div id="container">
    	<div id="newProject">
        	<h2>Create a New Project!</h2>
            <form name="newproj" action="../php/projMgmt.php?newproj" method="post">
       	    	<p>Project Name: <input type="text" name= "projName" class="textarea"> </p>
           	<p>Event Name: <input type="text" name="last" class="textarea"> </p>
          		<div style="clear:both"></div>
				<input type="submit" value="Submit" class="button"><br/>              
       		</form>
        </div>
        <div id="existingProjects">
        	<h2> You have the following existing projects! </h2>
        	<?php
				include ("../php/mysqli.php");
				global $db_obj;
			
				$query = "SELECT * FROM Products WHERE uid = '". $_SESSION['userid']."'";
				
				if ( ($result = $db_obj->query($query)) && ($result->num_rows != 0) ){  // success!
					$st = "";
				 	while ($row = $result->fetch_assoc()) {
						$st .= "<p>";
						$st .= $row['product']. "</p>";
    				}
					echo $st;
				}
				else{
			 		echo "No Projects so far!";
				}
			?>
            <a href="../php/authentication.php?logout">Logout</a>
        </div>
    </div>
</body>
</html>