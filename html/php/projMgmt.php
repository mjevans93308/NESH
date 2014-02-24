<?php
	session_start();
?>


<html>
	<body>
    <?php
		include ("../php/mysqli.php");
		
		
    	if(isset($_GET['newproj'])){
			$flag = createProj($_SESSION["userid"], $_POST["projName"]);
			if($flag){
				//header("Location: basicpages/first.php");
				echo "<script>window.location= 'http://nesh.co/basicPages/first.php'</script>";
				unset($_GET['newproj']);
			}
			else{
				echo "<p>Error! Didnt create a new Porject</p>";
			}
		}
		
		
		function createProj($uid1, $proj1){ 
  			global $db_obj;
  			$uid=$db_obj->escape_string($uid1);      // (A)
  			$proj=$db_obj->escape_string($proj1); // (B)
  
  			$query="INSERT INTO Products VALUES ('$proj', '$uid')"; // (D)
			
			$hashNum = 00000000001;
			
			$query1 = "INSERT INTO Hash_Products VALUES ('$proj', $hashNum)";
  			return (($db_obj->query($query)) && ($db_obj ->query($query1)));                    // (E)
			}
	?>
	</body>
</html>