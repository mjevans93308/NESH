<?php
	session_start();
?>


<html>
	<body>
    <?php
		include ("../php/mysqli.php");
		
		
    	if(isset($_GET['newproj'])){
			$totalTags = 0;
			$totalEvents = 0;
			
			while($totalEvents >= 0){
				$l = "event" .($totalEvents + 1);
				if(isset($_POST[$l])){
					${'event_id' . $totalEvents} = $_POST[$l];
				}
				else
					break;
				$totalEvents = $totalEvents + 1;
			}
			
			while($totalTags < 6){
				$k = "tag" .($totalTags + 1);
				if(isset($_POST[$k])){
					${'tag_id' . $totalTags} = $_POST[$k];
				}
				else
					break;
				$totalTags = $totalTags + 1;
			}
			
			for($a = 0; $a < $totalEvents; $a++){
				echo ${'event_id'.$a};
			}
			
			for($b = 0; $b < $totalTags; $b++){
				echo ${'tag_id'.$b};
			}
			
			
			
			
			global $db_obj;
  			$uid=$db_obj->escape_string($uid1);      // (A)
  			$proj=$db_obj->escape_string($proj1); // (B)
  
  			$query="INSERT INTO Products VALUES ('$proj', '$uid')"; // (D)
			
			$hashNum = 00000000001;
			
			$query1 = "INSERT INTO Hash_Products VALUES ('$proj', $hashNum)";
  			return (($db_obj->query($query)) && ($db_obj ->query($query1))); 
			
			
			if($flag){
				//header("Location: basicpages/first.php");
				echo "<script>window.location= 'http://nesh.co/basicPages/first.php'</script>";
				unset($_GET['newproj']);
			}
			else{
				echo "<p>Error! Didnt create a new Porject</p>";
			}
		}
		
	?>
	</body>
</html>